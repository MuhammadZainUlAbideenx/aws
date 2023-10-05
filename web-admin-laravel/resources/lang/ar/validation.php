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

    'accepted' => 'The :attribute يجب قبوله.',
    'active_url' => 'The :attribute ليس عنوان URL صالحًا.',
    'after' => 'The :attributeيجب أن يكون تاريخًا بعد :date.',
    'after_or_equal' => 'The :attribute يجب أن يكون تاريخًا بعد أو يساوي :date.',
    'alpha' => 'The :attribute قد تحتوي على أحرف فقط.',
    'alpha_dash' => 'The :attribute قد تحتوي فقط على أحرف وأرقام وشرطات وشرطات سفلية.',
    'alpha_num' => 'The :attribute قد تحتوي فقط على أحرف وأرقام وشرطات وشرطات سفلية.',
    'array' => 'The :attribute يجب أن يكون مصفوفة.',
    'before' => 'The :attribute يجب أن يكون تاريخًا سابقًا  :date.',
    'before_or_equal' => 'The :attribute يجب أن يكون تاريخًا يسبق أو يساوي :date.',
    'between' => [
        'numeric' => 'The :attribute لابد ان تكون بالوسط:min و :max.',
        'file' => 'The :attribute لابد ان تكون بالوسط:min و :max كيلوبايت.',
        'string' => 'The :attribute لابد ان تكون بالوسط:min و :max الشخصيات.',
        'array' => 'The :attribute يجب أن يكون بين :min و :max العناصر.',
    ],
    'boolean' => 'The :attribute يجب أن يكون الحقل صحيحًا أو خطأ.',
    'confirmed' => 'The :attribute التأكيد غير متطابق.',
    'date' => 'The :attribute هذا ليس تاريخ صحيح.',
    'date_equals' => 'The :attributeيجب أن يكون تاريخًا مساويًا لـ :date.',
    'date_format' => 'The :attribute لا يتطابق مع الشكلt :format.',
    'different' => 'The :attribute و :other يجب أن تكون مختلف.',
    'digits' => 'The :attributeلا بد وأن :digits أرقام.',
    'digits_between' => 'The :attribute لابد ان تكون بالوسط :min و :max أرقام.',
    'dimensions' => 'The :attribute أبعاد الصورة غير صالحة.',
    'distinct' => 'The :attribute الحقل له قيمة مكررة.',
    'email' => 'The :attribute يجب أن يكون عنوان بريد إلكتروني صالح.',
    'ends_with' => 'The :attribute يجب أن ينتهي بواحد مما يلي: :values.',
    'exists' => 'The selected :attribute غير صالح.',
    'file' => 'The :attribute يجب أن يكون ملفًا.',
    'filled' => 'The :attribute يجب أن يكون للحقل قيمة.',
    'gt' => [
        'numeric' => 'The :attribute يجب أن يكون أكبر من :value.',
        'file' => 'The :attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'string' => 'The :attribute يجب أن يكون أكبر من :value الشخصيات.',
        'array' => 'The :attribute  يجب أن يحتوي على أكثر من :value العناصر.',
    ],
    'gte' => [
        'numeric' => 'The :attribute يجب أن يكون أكبر من أو يساوي :value.',
        'file' => 'The :attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.',
        'string' => 'The :attribute يجب أن يكون أكبر من أو يساوي :value الشخصيات.',
        'array' => 'The :attribute يجب ان يملك :value من العناصر أو أكثر.',
    ],
    'image' => 'The :attribute يجب أن تكون صورة.',
    'in' => 'The selected :attribute غير صالح.',
    'in_array' => 'The :attribute الحقل غير موجود في :other.',
    'integer' => 'The :attribute يجب أن يكون صحيحا.',
    'ip' => 'The :attribute يجب أن يكون عنوان IP صالحًا.',
    'ipv4' => 'The :attribute يجب أن يكون عنوان IPv4 صالحًا.',
    'ipv6' => 'The :attribute يجب أن يكون عنوان IPv6 صالحًا.',
    'json' => 'The :attribute يجب أن تكون سلسلة JSON صالحة.',
    'lt' => [
        'numeric' => 'The :attributeيجب أن يكون أقل من :value.',
        'file' => 'The :attributeيجب أن يكون أقل من :value كيلوبايت.',
        'string' => 'The :attributeيجب أن يكون أقل من :value الشخصيات.',
        'array' => 'The :attribute يجب أن يكون أقل من:value العناصر.',
    ],
    'lte' => [
        'numeric' => 'The :attribute يجب أن يكون أصغر من أو يساوي :value.',
        'file' => 'The :attribute يجب أن يكون أصغر من أو يساوي :value كيلوبايت.',
        'string' => 'The :attribute يجب أن يكون أصغر من أو يساوي :value الشخصيات.',
        'array' => 'The :attributeيجب ألا يحتوي على أكثر من:value العناصر.',
    ],
    'max' => [
        'numeric' => 'The :attributeقد لا يكون أكبر من :max.',
        'file' => 'The :attributeقد لا يكون أكبر من :max كيلوبايت.',
        'string' => 'The :attributeقد لا يكون أكبر من :max الشخصيات.',
        'array' => 'The :attribute قد لا يكون أكثر من :max العناصر.',
    ],
    'mimes' => 'The :attribute يجب أن يكون ملف type: :values.',
    'mimetypes' => 'The :attribute يجب أن يكون ملف type: :values.',
    'min' => [
        'numeric' => 'The :attribute لا بد أن يكون على الأقل :min.',
        'file' => 'The :attribute لا بد أن يكون على الأقل :min كيلوبايت.',
        'string' => 'The :attribute لا بد أن يكون على الأقل :min الشخصيات.',
        'array' => 'The :attribute يجب أن يكون على الأقل:min العناصر.',
    ],
    'multiple_of' => 'The :attribute يجب أن يكون من مضاعفات :value',
    'not_in' => 'The selected :attribute غير صالح.',
    'not_regex' => 'The :attribute format غير صالح.',
    'numeric' => 'The :attribute يجب أن يكون رقما.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'The :attribute يجب أن يكون الحقل موجودًا.',
    'regex' => 'The :attribute التنسيق غير صالح.',
    'required' => 'The :attribute الحقل مطلوب.',
    'required_if' => 'The :attribute الحقل مطلوب عندما :other هو :value.',
    'required_unless' => 'The :attribute الحقل مطلوب ما لم يكن :other في داخل :values.',
    'required_with' => 'The :attribute الحقل مطلوب عندما :values هو present.',
    'required_with_all' => 'The :attribute الحقل مطلوب عندما :values حاضرون.',
    'required_without' => 'The :attribute الحقل مطلوب عندما :values غير موجود.',
    'required_without_all' => 'The :attribute الحقل مطلوبًا في حالة عدم وجود أي من:values حاضرون.',
    'same' => 'The :attribute و :other يجب أن تتطابق.',
    'size' => [
        'numeric' => 'The :attribute لا بد وأن :size.',
        'file' => 'The :attribute لا بد وأن :size كيلوبايت.',
        'string' => 'The :attribute لا بد وأن :size الشخصيات.',
        'array' => 'The :attribute يجب أن تحتوي على :size العناصر.',
    ],
    'starts_with' => 'The :attribute يجب أن تبدأ بأحد following: :values.',
    'string' => 'The :attribute يجب أن يكون سلسلة.',
    'timezone' => 'The :attribute يجب أن تكون منطقة صالحة.',
    'unique' => 'The :attribute لقد اتخذت بالفعل.',
    'uploaded' => 'The :attribute فشل التحميل.',
    'url' => 'The :attribute التنسيق غير صالح.',
    'uuid' => 'The :attribute يجب أن يكون UUID صالحًا.',

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
            'rule-name' => 'رسالة مخصصة',
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
