<?php
 
namespace StationaryInvoicePayment\Helper;
 
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Plenty\Modules\Payment\Method\Models\PaymentMethod;
 
/**
 * Class Helper
 *
 * @package StationaryInvoicePayment\Helper
 */
class Helper
{
    /**
     * @var PaymentMethodRepositoryContract $paymentMethodRepository
     */
    private $paymentMethodRepository;
 
    /**
     * Helper constructor.
     *
     * @param PaymentMethodRepositoryContract $paymentMethodRepository
     */
    public function __construct(PaymentMethodRepositoryContract $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }
 
    /**
     * Create the ID of the payment method if it doesn't exist yet
     */
    public function createMopIfNotExists()
    {

        if($this->getPaymentMethod() == 'no_paymentmethod_found')
        {
            $paymentMethodData = array( 'pluginKey' => 'plenty_StationaryInvoicePayment',
                                        'paymentKey' => 'StationaryInvoicePayment',
                                        'name' => 'Zahlung Rechnung über Kasse');
 
            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }
    }
 
    /**
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getPaymentMethod()
    {
        $paymentMethods = $this->paymentMethodRepository->allForPlugin('plenty_StationaryInvoicePayment');
 
        if( !is_null($paymentMethods) )
        {
            foreach($paymentMethods as $paymentMethod)
            {
                if($paymentMethod->paymentKey == 'StationaryInvoicePayment')
                {
                    return $paymentMethod->id;
                }
            }
        }
 
        return 'no_paymentmethod_found';
    }
}
