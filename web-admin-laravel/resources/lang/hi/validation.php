<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute स्वीकार किया जाना चाहिए.',
    'active_url' => 'The :attribute मान्य URL नहीं है.',
    'after' => 'The :attribute के बाद की तारीख होनी चाहिए :date.',
    'after_or_equal' => 'The :attributeके बाद या उसके बराबर की तारीख होनी चाहिए :date.',
    'alpha' => 'The :attribute केवल अक्षर हो सकते हैं.',
    'alpha_dash' => 'The :attribute केवल अक्षर, संख्याएं, डैश और अंडरस्कोर हो सकते हैं.',
    'alpha_num' => 'The :attribute केवल अक्षर और संख्याएँ हो सकती हैं.',
    'array' => 'The :attribute एक सरणी होना चाहिए।',
    'before' => 'The :attribute पहले की तारीख होनी चाहिए :date.',
    'before_or_equal' => 'The :attribute तारीख से पहले या उसके बराबर होनी चाहिए :date.',
    'between' => [
        'numeric' => 'The :attribute के बीच होना चाहिए :min and :max.',
        'file' => 'The :attribute के बीच होना चाहिए :min and :max किलोबाइट.',
        'string' => 'The :attribute के बीच होना चाहिए :min and :max पात्र.',
        'array' => 'The :attribute के बीच होना चाहिए :min and :max सामान.',
    ],
    'boolean' => 'The :attribute फ़ील्ड सही या गलत होना चाहिए.',
    'confirmed' => 'The :attribute पुष्टि मेल नहीं खाती.',
    'date' => 'The :attribute वैध तारीख नहीं है.',
    'date_equals' => 'The :attribute वैध तारीख नहीं है :date.',
    'date_format' => 'The :attribute प्रारूप से मेल नहीं खाता :format.',
    'different' => 'The :attribute and :other अलग होना चाहिए.',
    'digits' => 'The :attribute होना चाहिए :digits अंक.',
    'digits_between' => 'The :attributeके बीच होना चाहिए :min and :max अंक.',
    'dimensions' => 'The :attribute अमान्य छवि आयाम हैं.',
    'distinct' => 'The :attribute फ़ील्ड का डुप्लिकेट मान है।',
    'email' => 'The :attribute एक वैध ई - मेल पता होना चाहिए.',
    'ends_with' => 'The :attribute निम्नलिखित में से किसी एक के साथ समाप्त होना चाहिए: :values.',
    'exists' => 'चुना हुआ :attribute अमान्य है.',
    'file' => 'The :attribute एक फ़ाइल होना चाहिए.',
    'filled' => 'The :attribute फ़ील्ड का मान होना चाहिए.',
    'gt' => [
        'numeric' => 'The :attribute से बड़ा होना चाहिए :value.',
        'file' => 'The :attribute से बड़ा होना चाहिए :value किलोबाइट.',
        'string' => 'The :attribute से बड़ा होना चाहिए :value पात्र.',
        'array' => 'The :attribute से अधिक होना चाहिए :value सामान.',
    ],
    'gte' => [
        'numeric' => 'The :attribute से बड़ा या बराबर होना चाहिए :value.',
        'file' => 'The :attribute से बड़ा या बराबर होना चाहिए :value किलोबाइट.',
        'string' => 'The :attribute से बड़ा या बराबर होना चाहिए :value पात्र.',
        'array' => 'The :attribute होना आवश्यक है :value आइटम या अधिक.',
    ],
    'image' => 'The :attribute एक छवि होना चाहिए.',
    'in' => 'चुना हुआ :attribute अमान्य है.',
    'in_array' => 'The :attribute फ़ील्ड मौजूद नहीं है :other.',
    'integer' => 'The :attribute पूर्णांक होना चाहिए.',
    'ip' => 'The :attribute एक वैध आईपी पता होना चाहिए.',
    'ipv4' => 'The :attribute एक मान्य IPv4 पता होना चाहिए.',
    'ipv6' => 'The :attribute एक मान्य IPv6 पता होना चाहिए.',
    'json' => 'The :attribute एक वैध JSON स्ट्रिंग होना चाहिए.',
    'lt' => [
        'numeric' => 'The :attributeसे कम होना चाहिए :value.',
        'file' => 'The :attribute से कम होना चाहिए :value किलोबाइट.',
        'string' => 'The :attribute से कम होना चाहिए :value पात्र.',
        'array' => 'The :attribute से कम होना चाहिए :value सामान.',
    ],
    'lte' => [
        'numeric' => 'The :attribute से कम या बराबर होना चाहिए :value.',
        'file' => 'The :attribute से कम या बराबर होना चाहिए :value किलोबाइट.',
        'string' => 'The :attribute से कम या बराबर होना चाहिए :value पात्र.',
        'array' => 'The :attribute से अधिक नहीं होना चाहिए :value सामान.',
    ],
    'max' => [
        'numeric' => 'The :attribute से बड़ा नहीं हो सकता :max.',
        'file' => 'The :attribute से बड़ा नहीं हो सकता :max किलोबाइट.',
        'string' => 'The :attribute से बड़ा नहीं हो सकता :max पात्र.',
        'array' => 'The :attribute से अधिक नहीं हो सकता है :max सामान.',
    ],
    'mimes' => 'The :attribute प्रकार की एक फ़ाइल होनी चाहिए: :values.',
    'mimetypes' => 'The :attribute प्रकार की एक फ़ाइल होनी चाहिए: :values.',
    'min' => [
        'numeric' => 'The :attribute कम से कम होना चाहिए :min.',
        'file' => 'The :attribute कम से कम होना चाहिए :min किलोबाइट.',
        'string' => 'The :attribute कम से कम होना चाहिए :min पात्र.',
        'array' => 'The :attribute कम से कम होना चाहिए :min सामान.',
    ],
    'multiple_of' => 'The :attribute का गुणज होना चाहिए :value',
    'not_in' => 'चुना हुआ :attribute अमान्य है.',
    'not_regex' => 'The :attribute प्रारूप अमान्य है.',
    'numeric' => 'The :attribute एक संख्या होनी चाहिए.',
    'password' => 'पासवर्ड गलत है.',
    'present' => 'The :attribute क्षेत्र मौजूद होना चाहिए.',
    'regex' => 'The :attribute प्रारूप अमान्य है.',
    'required' => 'The :attribute ये स्थान भरा जाना है.',
    'required_if' => 'The :attribute फ़ील्ड की आवश्यकता होती है जब :other is :value.',
    'required_unless' => 'The :attribute फ़ील्ड आवश्यक है जब तक :other is in :values.',
    'required_with' => 'The :attribute फ़ील्ड की आवश्यकता होती है जब :values उपस्थित है.',
    'required_with_all' => 'The :attribute फ़ील्ड की आवश्यकता होती है जब :values मौजूद हैं.',
    'required_without' => 'The :attribute फ़ील्ड की आवश्यकता होती है जब :values मौजूद नहीं है.',
    'required_without_all' => 'The :attribute फ़ील्ड की आवश्यकता होती है जब कोई नहीं :values मौजूद हैं.',
    'same' => 'The :attribute तथा :other मेल खाना चाहिए.',
    'size' => [
        'numeric' => 'The :attribute होना चाहिए :size.',
        'file' => 'The :attribute होना चाहिए :size किलोबाइट.',
        'string' => 'The :attribute होना चाहिए :size पात्र.',
        'array' => 'The :attribute शामिल होना चाहिए :size सामान.',
    ],
    'starts_with' => 'The :attributeनिम्नलिखित में से किसी एक के साथ शुरू होना following: :values.',
    'string' => 'The :attribute एक स्ट्रिंग होना चाहिए.',
    'timezone' => 'The :attribute एक वैध क्षेत्र होना चाहिए.',
    'unique' => 'The :attribute पहले से ही लिया जा चुका है.',
    'uploaded' => 'The :attribute अपलोड करने में विफल.',
    'url' => 'The :attribute प्रारूप अमान्य है.',
    'uuid' => 'The :attribute एक वैध यूयूआईडी होना चाहिए.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'सीमा शुल्क संदेश',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
