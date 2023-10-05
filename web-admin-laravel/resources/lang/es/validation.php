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

    'accepted' => 'el :attribute debe ser aceptado.',
    'active_url' => 'el :attribute no es una URL válida.',
    'after' => 'el :attribute debe ser una fecha posterior :date.',
    'after_or_equal' => 'el :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'el :attribute solo puede contener letras.',
    'alpha_dash' => 'el :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'el :attribute solo puede contener letras y números.',
    'array' => 'el :attribute debe ser una matriz.',
    'before' => 'el :attribute debe ser una fecha anterior :date.',
    'before_or_equal' => 'el :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'el :attribute debe estar entre :min y :max.',
        'file' => 'el :attribute debe estar entre :min y :max kilobytes.',
        'string' => 'el :attribute debe estar entre :min y :max caracteres.',
        'array' => 'el :attribute debe tener entre :min y :max elementos.',
    ],
    'boolean' => 'el :attribute el campo debe ser verdadero o falso.',
    'confirmed' => 'el :attribute la confirmación no coincide.',
    'date' => 'el :attribute no es una fecha válida.',
    'date_equals' => 'el :attribute debe ser una fecha igual a :date.',
    'date_format' => 'el :attribute no coincide con el formato :format.',
    'different' => 'el :attribute y :other debe ser diferente.',
    'digits' => 'el :attribute debe ser :digits digits.',
    'digits_between' => 'el :attribute debe estar entre :min and :max dígitos.',
    'dimensions' => 'el :attribute tiene dimensiones de imagen no válidas.',
    'distinct' => 'el :attribute el campo tiene un valor duplicado.',
    'email' => 'el :attribute Debe ser una dirección de correo electrónico válida.',
    'ends_with' => 'el :attribute debe terminar con uno de los siguientes :values.',
    'exists' => 'el seleccionada :attribute Es inválida.',
    'file' => 'el :attribute debe ser un archivo.',
    'filled' => 'el :attribute el campo debe tener un valor.',
    'gt' => [
        'numeric' => 'el :attribute debe ser mayor que :value.',
        'file' => 'el :attribute debe ser mayor que :value kilobytes.',
        'string' => 'el :attribute debe ser mayor que :value caracteres.',
        'array' => 'el :attribute debe tener más de :value elementos.',
    ],
    'gte' => [
        'numeric' => 'el :attribute debe ser mayor o igual :value.',
        'file' => 'el :attribute debe ser mayor o igual :value kilobytes.',
        'string' => 'el :attribute debe ser mayor o igual :value caracteres.',
        'array' => 'el :attribute debe tener :value artículos o más.',
    ],
    'image' => 'el :attribute debe ser una imagen.',
    'in' => 'el seleccionada :attribute Es inválida.',
    'in_array' => 'el :attribute campo no existe en :other.',
    'integer' => 'el :attribute debe ser un entero.',
    'ip' => 'el :attribute debe ser una dirección IP válida.',
    'ipv4' => 'el :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'el :attribute debe ser una dirección IPv6 válida.',
    'json' => 'el :attribute debe ser una cadena JSON válida.',
    'lt' => [
        'numeric' => 'el :attribute debe ser menor que :value.',
        'file' => 'el :attribute debe ser menor que :value kilobytes.',
        'string' => 'el :attribute debe ser menor que :value caracteres.',
        'array' => 'el :attribute debe tener menos de :value elementos.',
    ],
    'lte' => [
        'numeric' => 'el :attribute debe ser menor o igual :value.',
        'file' => 'el :attribute debe ser menor o igual :value kilobytes.',
        'string' => 'el :attribute debe ser menor o igual :value caracteres.',
        'array' => 'el :attribute no debe tener más de :value elementos.',
    ],
    'max' => [
        'numeric' => 'el :attribute no puede ser mayor que :max.',
        'file' => 'el :attribute no puede ser mayor que :max kilobytes.',
        'string' => 'el :attribute no puede ser mayor que :max caracteres.',
        'array' => 'el :attribute no puede tener más de :max elementos.',
    ],
    'mimes' => 'el :attribute debe ser un archivo de type: :values.',
    'mimetypes' => 'el :attribute debe ser un archivo de type: :values.',
    'min' => [
        'numeric' => 'el :attribute debe ser por lo menos :min.',
        'file' => 'el :attribute debe ser por lo menos :min kilobytes.',
        'string' => 'el :attribute debe ser por lo menos :min caracteres.',
        'array' => 'el :attribute debe tener al menos :min elementos.',
    ],
    'multiple_of' => 'el :attribute debe ser múltiplo de :value',
    'not_in' => 'el seleccionada :attribute Es inválida.',
    'not_regex' => 'el :attribute format Es inválida.',
    'numeric' => 'el :attribute Tiene que ser un número.',
    'password' => 'el La contraseña es incorrecta.',
    'present' => 'el :attribute el campo debe estar presente.',
    'regex' => 'el :attribute el formato no es válido.',
    'required' => 'el :attribute Se requiere campo.',
    'required_if' => 'el :attribute el campo es obligatorio cuando :other es :value.',
    'required_unless' => 'el :attribute el campo es obligatorio a menos que :other es en :values.',
    'required_with' => 'el :attribute el campo es obligatorio cuando :values está presente.',
    'required_with_all' => 'el :attribute el campo es obligatorio cuando :values están presentes.',
    'required_without' => 'el :attribute el campo es obligatorio cuando :values no es presente.',
    'required_without_all' => 'el :attribute El campo es obligatorio cuando ninguno de :values están presentes.',
    'same' => 'el :attribute y :other debe coincidir con.',
    'size' => [
        'numeric' => 'el :attribute debe ser :size.',
        'file' => 'el :attribute debe ser :size kilobytes.',
        'string' => 'el :attribute debe ser :size caracteres.',
        'array' => 'el :attribute must contain :size elementos.',
    ],
    'starts_with' => 'el :attribute debe comenzar con uno de los following: :values.',
    'string' => 'el :attribute debe ser una cadena.',
    'timezone' => 'el :attribute debe ser una zona válida.',
    'unique' => 'el :attribute ya se ha tomado.',
    'uploaded' => 'el :attribute no se pudo cargar.',
    'url' => 'el :attribute el formato no es válido.',
    'uuid' => 'el :attribute debe ser un UUID válido.',

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
            'rule-name' => 'custom-message',
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
