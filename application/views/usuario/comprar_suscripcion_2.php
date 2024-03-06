<p><?php print_r($respuesta_cliente->id); ?></p>
<p><?php echo $respuesta_cliente->id; ?></p>
<br>
<br>
<p><?php print_r($respuesta_tarjeta); ?></p>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
OpenpayCustomer Object ( [status:protected] => active [creation_date:protected] => 2020-06-10T11:43:30-05:00 [balance:protected] => 0 [clabe:protected] => [derivedResources:protected] => Array ( 
    [cards] => OpenpayCardList Object ( 
            [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
            [id:protected] => [parent:protected] => OpenpayCustomer Object *RECURSION* 
            [resourceName:protected] => OpenpayCard 
            [serializableData:protected] => Array ( ) 
            [noSerializableData:protected] => Array ( ) 
            [derivedResources:protected] => 
        ) 
    [bankaccounts] => OpenpayBankAccountList Object ( 
        [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
        [id:protected] => [parent:protected] => OpenpayCustomer Object *RECURSION* 
        [resourceName:protected] => OpenpayBankAccount [serializableData:protected] => Array ( ) 
        [noSerializableData:protected] => Array ( ) [derivedResources:protected] => 
    ) 
    [charges] => OpenpayChargeList Object ( 
        [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
        [id:protected] => [parent:protected] => OpenpayCustomer Object *RECURSION* 
        [resourceName:protected] => OpenpayCharge [serializableData:protected] => Array ( ) 
        [noSerializableData:protected] => Array ( ) [derivedResources:protected] => 
    ) 
    [transfers] => OpenpayTransferList Object ( 
        [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
        [id:protected] => 
        [parent:protected] => OpenpayCustomer Object *RECURSION* 
        [resourceName:protected] => OpenpayTransfer 
        [serializableData:protected] => Array ( ) 
        [noSerializableData:protected] => Array ( ) 
        [derivedResources:protected] => 
    ) 
    [payouts] => OpenpayPayoutList Object ( 
        [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
        [id:protected] => 
        [parent:protected] => 
        OpenpayCustomer Object *RECURSION* 
        [resourceName:protected] => OpenpayPayout 
        [serializableData:protected] => Array ( ) 
        [noSerializableData:protected] => Array ( ) 
        [derivedResources:protected] => 
    ) 
    [subscriptions] => OpenpaySubscriptionList Object ( 
        [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
        [id:protected] => 
        [parent:protected] => OpenpayCustomer Object *RECURSION* 
        [resourceName:protected] => OpenpaySubscription 
        [serializableData:protected] => Array ( ) 
        [noSerializableData:protected] => Array ( ) 
        [derivedResources:protected] => 
    ) 
) 
[id:protected] => aqr6bhpkxl7uqcv9ohu8 
[parent:protected] => OpenpayCustomerList Object ( 
    [cacheList:OpenpayApiDerivedResource:private] => Array ( 
        [aqr6bhpkxl7uqcv9ohu8] => OpenpayCustomer Object *RECURSION* 
    ) 
    [id:protected] => 
    [parent:protected] => OpenpayApi Object ( 
        [derivedResources:protected] => Array ( 
            [customers] => OpenpayCustomerList Object *RECURSION* 
            [cards] => OpenpayCardList Object ( 
                [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
                [id:protected] => 
                [parent:protected] => OpenpayApi Object *RECURSION* 
                [resourceName:protected] => OpenpayCard 
                [serializableData:protected] => Array ( ) 
                [noSerializableData:protected] => Array ( ) 
                [derivedResources:protected] =>
            ) 
            [charges] => OpenpayChargeList Object ( 
                [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
                [id:protected] => 
                [parent:protected] => OpenpayApi Object *RECURSION* 
                [resourceName:protected] => OpenpayCharge 
                [serializableData:protected] => Array ( ) 
                [noSerializableData:protected] => Array ( ) 
                [derivedResources:protected] => 
            ) 
            [payouts] => OpenpayPayoutList Object ( 
                [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
                [id:protected] => 
                [parent:protected] => OpenpayApi Object *RECURSION* 
                [resourceName:protected] => OpenpayPayout 
                [serializableData:protected] => Array ( ) 
                [noSerializableData:protected] => Array ( ) 
                [derivedResources:protected] => 
            ) 
            [fees] => OpenpayFeeList Object ( 
                [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
                [id:protected] => 
                [parent:protected] => OpenpayApi Object *RECURSION* 
                [resourceName:protected] => OpenpayFee 
                [serializableData:protected] => Array ( ) 
                [noSerializableData:protected] => Array ( ) 
                [derivedResources:protected] => 
            ) 
            [plans] => OpenpayPlanList Object ( 
                [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
                [id:protected] => 
                [parent:protected] => OpenpayApi Object *RECURSION* 
                [resourceName:protected] => OpenpayPlan 
                [serializableData:protected] => Array ( ) 
                [noSerializableData:protected] => Array ( ) 
                [derivedResources:protected] => 
            ) 
            [webhooks] => OpenpayApiDerivedResource Object ( 
                [cacheList:OpenpayApiDerivedResource:private] => Array ( ) 
                [id:protected] => 
                [parent:protected] => OpenpayApi Object *RECURSION* 
                [resourceName:protected] => OpenpayWebhook 
                [serializableData:protected] => Array ( ) 
                [noSerializableData:protected] => Array ( ) 
                [derivedResources:protected] => 
            ) 
            [tokens] => OpenpayApiDerivedResource Object ( 
                [cacheList:OpenpayApiDerivedResource:private] => Array ( ) [id:protected] => [parent:protected] => OpenpayApi Object *RECURSION* [resourceName:protected] => OpenpayToken [serializableData:protected] => Array ( ) [noSerializableData:protected] => Array ( ) [derivedResources:protected] => ) ) [id:protected] => [parent:protected] => [resourceName:protected] => OpenpayApi [serializableData:protected] => Array ( ) [noSerializableData:protected] => Array ( ) ) [resourceName:protected] => OpenpayCustomer [serializableData:protected] => Array ( ) [noSerializableData:protected] => Array ( ) [derivedResources:protected] => ) [resourceName:protected] => OpenpayCustomer [serializableData:protected] => Array ( [name] => Mi cliente uno [last_name] => [email] => micliente@gmail.com [phone_number] => [address] => [external_id] => ) [noSerializableData:protected] => Array ( ) )  