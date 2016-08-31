<?php
/**
 * Copyright 2016 Resurs Bank AB
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Resursbank\OmniCheckout\Model\Payment;

/**
 * Standard payment method, when the request Resursbank method is not implemented.
 *
 * Class Standard
 * @package Resursbank\OmniCheckout\Model\Payment
 */
class Standard extends \Magento\Payment\Model\Method\AbstractMethod
{
    
    const PAYMENT_METHOD_RESURSBANK_STANDARD_CODE = 'resursbank_default';

    /**
     * Payment method code.
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_RESURSBANK_STANDARD_CODE;

    /**
     * Availability option.
     *
     * @var bool
     */
    protected $_isOffline = true;

}
