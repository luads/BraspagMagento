<?php

/*
 * This file is part of the Tapronto Braspag module.
 *
 * (c) 2012 Tapronto
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @author Luã de Souza <contato@lsouza.pro.br>
 */
class Tapronto_Braspag_Model_Payment extends Mage_Payment_Model_Method_Cc 
{
    protected $_isGateway = true;
    protected $_isInitializeNeeded = true;
    protected $_canAuthorize = true;
    protected $_canCapture = true;
    protected $_canVoid = true;
    protected $_canUseInternal = true;
    protected $_canUseCheckout = true;
    
    protected $_code = 'braspag';
    protected $_formBlockType = 'braspag/payment_form';
    
    public function assignData($data)
    {
        parent::assignData($data);
        
        $info = $this->getInfoInstance();
        
        $info->setCcParcelamento($data->getCcParcelamento());
        $this->getCheckout()->setCcParcelamento($data->getCcParcelamento());        
        
        return $this;
    }
    
    public function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }
    
    public function initialize($paymentAction, $stateObject)
    {
        $payment = $this->getInfoInstance();
        $order = $payment->getOrder();
        
        $payment->authorize(true, $order->getTotalDue());
        $payment->setAmountAuthorized($order->getTotalDue());
        
        $transacao = $this->processPayment($payment, $order->getBaseTotalDue());
        
        $payment->setCcParcelamento($transacao->getNumberPayments());

        $this->createTransactions($transacao->getTransactionId());
        $payment->setLastTransId($transacao->getTransactionId() . '-auth');
        
        // pagamento realizado com sucesso
		if(in_array($transacao->getStatus(), array('0', '1', '12', '13')))
		{
		    $this->setStore($payment->getOrder()->getStoreId());
    		$payment->setAmount($amount);
            $payment->setStatus(self::STATUS_APPROVED);
    		
            // caso precise de captura automatica, usar esse método para gerar o Invoice automaticamente
		    // $this->generateInvoice($order, $transacao->getTransactionId());
		    
		    $stateObject->setState(Mage_Sales_Model_Order::STATE_PROCESSING);
            $stateObject->setStatus($stateObject->getState());
            $stateObject->setIsNotified(true);
		}
		else
		{
		    $order->setCustomerNote('Pagamento não autorizado');
            
            $stateObject->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT);
            $stateObject->setStatus($stateObject->getState());
            $stateObject->setIsNotified(true);

            Mage::throwException('Pagamento não autorizado');
	    }
	    
	    return $this;
    }
    
    public function processPayment(Varien_Object $payment, $amount)
    {
        ini_set('soap.wsdl_cache_enabled', '0');

        $braspag_url = $this->getConfigData('service');

        $merchant_id = $this->getConfigData('merchant_id');
        $order = $payment->getOrder();
        $order_id = $order->getIncrementId();

		$soapclient = new Zend_Soap_Client($braspag_url);
		$parametros = array();
		
		$parametros['merchantId']  = (string) $merchant_id;
		$parametros['orderId']  = (string) $order_id;
		$parametros['customerName'] = (string) $payment->getCcOwner();
		$parametros['amount'] = (string) number_format($amount, 2, ',', '.');
		$parametros['paymentMethod']  = (string) $this->getMethodConfig($payment->getCcType());
		$parametros['holder']  = (string) $payment->getCcOwner();
		$parametros['cardNumber'] = (string) $payment->getCcNumber();
		$parametros['expiration'] = (string) $payment->getCcExpMonth() . '/' . $payment->getCcExpYear();
		$parametros['securityCode'] = (string) $payment->getCcCid();
		
		if (!$this->getCheckout()->getCcParcelamento())
		{
		    $parametros['numberPayments'] = '1';
    		$parametros['typePayment'] = '0';
		}
		else
		{
		    $parametros['numberPayments'] = '3';
    		$parametros['typePayment'] = $this->getParcelamentoType();
		}

		$authorize = $soapclient->Authorize($parametros);
		
		$resultado = $authorize->AuthorizeResult;

	    $transacao = Mage::getModel('braspag/braspag');
	    $transacao->setOrderId($order_id);
	    $transacao->setAuthorisation($resultado->authorisationNumber);
	    $transacao->setAmount($amount);
	    $transacao->setNumberPayments($parametros['numberPayments']);
	    $transacao->setTypePayment($parametros['typePayment']);
	    $transacao->setTransactionId($resultado->transactionId);
	    $transacao->setMessage($resultado->message);
	    $transacao->setReturnCode($resultado->returnCode);
	    $transacao->setStatus($resultado->status);
	    $transacao->save();
	    
	    return $transacao;
    }
    
    private function generateInvoice($order, $tid)
    {
        if ($order->canInvoice()) {
            $order->getPayment()->setTransactionId($tid);
            
            $invoice = $order->prepareInvoice();
            $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE);
            $invoice->register();

            Mage::getModel('core/resource_transaction')->addObject($invoice)->addObject($invoice->getOrder())->save();
            
            $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, 'processing', 'Pagamento autorizado com sucesso', true);
            $order->sendOrderUpdateEmail(true, '');
            $order->save();
        } else {
            $order->addStatusToHistory($order->getStatus(), 'Não foi possível gerar a fatura', false);
            $order->save();
        }
    }

    public function capture(Varien_Object $payment, $amount)
    {
        ini_set('soap.wsdl_cache_enabled', '0');

        $braspag_url = $this->getConfigData('service');

        $merchant_id = $this->getConfigData('merchant_id');
        $order_id = $payment->getOrder()->getIncrementId();

        $soapclient = new Zend_Soap_Client($braspag_url);
        $parametros = array();
        
        $parametros['merchantId']  = (string) $merchant_id;
        $parametros['orderId']  = (string) $order_id;

        $capture = $soapclient->Capture($parametros);

        $resultado = $capture->CaptureResult;

        $transacao = Mage::getModel('braspag/braspag');
        $transacao->setOrderId($order_id);
        $transacao->setAmount($resultado->amount);
        $transacao->setTransactionId($resultado->transactionId);
        $transacao->setMessage($resultado->message);
        $transacao->setReturnCode($resultado->returnCode);
        $transacao->setStatus($resultado->status);
        $transacao->save();

        return parent::capture($payment, $amount);
    }

    public function void(Varien_Object $document)
    {
        ini_set('soap.wsdl_cache_enabled', '0');

        $braspag_url = $this->getConfigData('service');

        $merchant_id = $this->getConfigData('merchant_id');
        $order_id = $document->getOrder()->getIncrementId();

        $soapclient = new Zend_Soap_Client($braspag_url);
        $parametros = array();
        
        $parametros['merchantId']  = (string) $merchant_id;
        $parametros['order']  = (string) $order_id;

        $void = $soapclient->VoidTransaction($parametros);

        $resultado = $void->VoidTransactionResult;

        $transacao = Mage::getModel('braspag/braspag');
        $transacao->setOrderId($order_id);
        $transacao->setAmount($resultado->amount);
        $transacao->setTransactionId($resultado->transactionId);
        $transacao->setMessage($resultado->message);
        $transacao->setReturnCode($resultado->returnCode);
        $transacao->setStatus($resultado->status);
        $transacao->save();

        return parent::void($document);
    }

    public function cancel(Varien_Object $payment)
    {
        return $this->void($payment);
    }
    
    private function getMethodConfig($cc_type)
    {
        $config = array(
            'AE' => $this->getConfigData('ws_amex'),
            'VI' => $this->getConfigData('ws_visa'),
            'MC' => $this->getConfigData('ws_master'),
        );
        
        return array_key_exists($cc_type, $config) ? $config[$cc_type] : 0;
    }

    public function createTransactions($id)
    {
        // usada na captura
        Mage::getModel('sales/order_payment_transaction')
            ->setOrderPaymentObject($this->getInfoInstance())
            ->setTxnId($id . '-order')
            ->setTxnType(Mage_Sales_Model_Order_Payment_Transaction::TYPE_ORDER)
            ->setIsClosed(0)
            ->save();   

        // usada no void
        Mage::getModel('sales/order_payment_transaction')
            ->setOrderPaymentObject($this->getInfoInstance())
            ->setTxnId($id . '-auth')
            ->setTxnType(Mage_Sales_Model_Order_Payment_Transaction::TYPE_AUTH)
            ->setIsClosed(0)
            ->save();    
    }
    
    public function getParcelamentoType()
    {
        $val = $this->getConfigData('parcelamento');
        
        return $val ? $val : 1;
    }
}