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

    'accepted' => 'দ্য :attribute গ্রহণ করা আবশ্যক।',
    'active_url' => 'দ্য :attribute একটি বৈধ URL নয়।',
    'after' => 'দ্য :attributeপরে একটি তারিখ হতে হবে :date.',
    'after_or_equal' => 'দ্য :attribute এর পরে বা সমান তারিখ হতে হবে:date.',
    'alpha' => 'দ্য :attribute শুধুমাত্র অক্ষর থাকতে পারে।',
    'alpha_dash' => 'দ্য :attribute শুধুমাত্র অক্ষর, সংখ্যা, ড্যাশ এবং আন্ডারস্কোর থাকতে পারে।',
    'alpha_num' => 'দ্য :attributeশুধুমাত্র অক্ষর এবং সংখ্যা থাকতে পারে।',
    'array' => 'দ্য :attribute একটি অ্যারে হতে হবে।',
    'before' => 'দ্য :attributeআগে একটি তারিখ হতে হবে :date.',
    'before_or_equal' => 'দ্য :attribute একটি তারিখ আগে বা সমান হতে হবে :date.',
    'between' => [
        'numeric' => 'দ্য :attribute মধ্যে হতে হবে:min এবং :max.',
        'file' => 'দ্য :attribute মধ্যে হতে হবে:min এবং :max কিলোবাইট',
        'string' => 'দ্য :attribute মধ্যে হতে হবে:min এবং :max চরিত্র.',
        'array' => 'দ্য :attribute মধ্যে থাকতে হবে :min এবং :max আইটেম।',
    ],
    'boolean' => 'দ্য :attribute ক্ষেত্র সত্য বা মিথ্যা হতে হবে।',
    'confirmed' => 'দ্য :attribute নিশ্চিতকরণ মেলে না।',
    'date' => 'দ্য :attribute একটি বৈধ তারিখ নয়।',
    'date_equals' => 'দ্য :attribute এর সমান একটি তারিখ হতে হবে :date.',
    'date_format' => 'দ্য :attribute বিন্যাসের সাথে মেলে না :format.',
    'different' => 'দ্য :attribute এবং :oদ্যr ভিন্ন হতে হবে.',
    'digits' => 'দ্য :attribute অবশ্যই :digits অঙ্ক.',
    'digits_between' => 'দ্য :attribute মধ্যে হতে হবে:min এবং :max 
    অঙ্ক.',
    'dimensions' => 'দ্য :attribute অবৈধ চিত্র মাত্রা আছে।',
    'distinct' => 'দ্য :attribute ক্ষেত্রের একটি ডুপ্লিকেট মান আছে।',
    'email' => 'দ্য :attribute একটি বৈধ ইমেইল ঠিকানা আবশ্যক.',
    'ends_with' => 'দ্য :attribute নিম্নলিখিতগুলির একটি দিয়ে শেষ করতে হবে: :values.',
    'exists' => 'দ্য নির্বাচিত :attribute অবৈধ.',
    'file' => 'দ্য :attribute একটি ফাইল হতে হবে।',
    'filled' => 'দ্য :attribute ক্ষেত্রের একটি মান থাকতে হবে।',
    'gt' => [
        'numeric' => 'দ্য :attribute mএর থেকে বড় হতে হবে :value.',
        'file' => 'দ্য :attribute mএর থেকে বড় হতে হবে :value কিলোবাইট',
        'string' => 'দ্য :attribute mএর থেকে বড় হতে হবে :value চরিত্র.',
        'array' => 'দ্য :attribute must have more than :value আইটেম।',
    ],
    'gte' => [
        'numeric' => 'দ্য :attribute mএর থেকে বড় হতে হবে বা সমান :value.',
        'file' => 'দ্য :attribute mএর থেকে বড় হতে হবে বা সমান :value কিলোবাইট',
        'string' => 'দ্য :attribute mএর থেকে বড় হতে হবে বা সমান :value চরিত্র.',
        'array' => 'দ্য :attribute অবশ্যই থাকতে হবে :value আইটেম বা আরও বেশি।',
    ],
    'image' => 'দ্য :attribute একটি ছবি হতে হবে।',
    'in' => 'দ্য নির্বাচিত :attribute অবৈধ.',
    'in_array' => 'দ্য :attribute ক্ষেত্র বিদ্যমান নেই :oদ্যr.',
    'integer' => 'দ্য :attribute একটি পূর্ণসংখ্যা হতে হবে।',
    'ip' => 'দ্য :attributeএকটি বৈধ IP ঠিকানা হতে হবে।',
    'ipv4' => 'দ্য :attribute একটি বৈধ IPv4 ঠিকানা হতে হবে।',
    'ipv6' => 'দ্য :attribute একটি বৈধ IPv6 ঠিকানা হতে হবে।',
    'json' => 'দ্য :attribute একটি বৈধ JSON স্ট্রিং হতে হবে।',
    'lt' => [
        'numeric' => 'দ্য :attribute থেকে কম হতে হবে :value.',
        'file' => 'দ্য :attribute থেকে কম হতে হবে :value কিলোবাইট',
        'string' => 'দ্য :attribute থেকে কম হতে হবে :value চরিত্র.',
        'array' => 'দ্য :attribute এর কম থাকতে হবে :value আইটেম।',
    ],
    'lte' => [
        'numeric' => 'দ্য :attribute এর থেকে কম বা সমান হতে হবে :value.',
        'file' => 'দ্য :attribute এর থেকে কম বা সমান হতে হবে :value কিলোবাইট',
        'string' => 'দ্য :attribute এর থেকে কম বা সমান হতে হবে :value চরিত্র.',
        'array' => 'দ্য :attribute এর বেশি থাকতে হবে না:value আইটেম।',
    ],
    'max' => [
        'numeric' => 'দ্য :attribute এর চেয়ে বেশি নাও হতে পারে :max.',
        'file' => 'দ্য :attribute এর চেয়ে বেশি নাও হতে পারে :max কিলোবাইট',
        'string' => 'দ্য :attribute এর চেয়ে বেশি নাও হতে পারে :max চরিত্র.',
        'array' => 'দ্য :attribute এর বেশি নাও থাকতে পারে :max আইটেম।',
    ],
    'mimes' => 'দ্য :attribute এর একটি ফাইল হতে হবে type: :values.',
    'mimetypes' => 'দ্য :attribute এর একটি ফাইল হতে হবে type: :values.',
    'min' => [
        'numeric' => 'দ্য :attribute নূন্যতম হতে হবে :min.',
        'file' => 'দ্য :attribute নূন্যতম হতে হবে :min কিলোবাইট',
        'string' => 'দ্য :attribute নূন্যতম হতে হবে :min চরিত্র.',
        'array' => 'দ্য :attributeঅন্তত থাকতে হবে :min আইটেম।',
    ],
    'multiple_of' => 'দ্য :attribute এর একাধিক হতে হবে :value',
    'not_in' => 'দ্য নির্বাচিত :attribute অবৈধ.',
    'not_regex' => 'দ্য :attribute বিন্যাস অবৈধ।',
    'numeric' => 'দ্য :attribute অবশ্যই একটি সংখ্যা হবে.',
    'password' => 'পাসওয়ার্ডটি ভূল.',
    'present' => 'দ্য :attribute ক্ষেত্র অবশ্যই উপস্থিত থাকতে হবে।',
    'regex' => 'দ্য :attribute বিন্যাস অবৈধ।',
    'required' => 'দ্য :attribute আপনি উত্তর দিবেন না.',
    'required_if' => 'দ্য :attribute ক্ষেত্রের প্রয়োজন হয় যখন :other হয় :value.',
    'required_unless' => 'দ্য :attribute ক্ষেত্রের প্রয়োজন যদি না :other মধ্যে আছে :values.',
    'required_with' => 'দ্য :attribute ক্ষেত্রের প্রয়োজন হয় যখন :values উপস্থিত.',
    'required_with_all' => 'দ্য :attribute ক্ষেত্রের প্রয়োজন হয় যখন :values উপস্থিত আছেন.',
    'required_without' => 'দ্য :attribute ক্ষেত্রের প্রয়োজন হয় যখন :values উপস্থিত নেই।',
    'required_without_all' => 'দ্য :attribute ক্ষেত্রের প্রয়োজন হয় যখন কোনটি নয় :values উপস্থিত আছেন.',
    'same' => 'দ্য :attribute এবং :other অবশ্যই দেখুন.',
    'size' => [
        'numeric' => 'দ্য :attribute অবশ্যই :size.',
        'file' => 'দ্য :attribute অবশ্যই :size কিলোবাইট',
        'string' => 'দ্য :attribute অবশ্যই :size চরিত্র.',
        'array' => 'দ্য :attribute অবশ্যই থাকতে হবে :size আইটেম',
    ],
    'starts_with' => 'দ্য :attribute একটি দিয়ে শুরু করতে হবে following: :values.',
    'string' => 'দ্য :attribute একটি স্ট্রিং হতে হবে।',
    'timezone' => 'দ্য :attribute একটি বৈধ অঞ্চল হতে হবে।',
    'unique' => 'দ্য :attribute আপলোড করতে ব্যর্থ হয়েছে।',
    'uploaded' => 'দ্য :attribute আপলোড করতে ব্যর্থ হয়েছে।',
    'url' => 'দ্য :attribute বিন্যাস অবৈধ।',
    'uuid' => 'দ্য :attribute একটি বৈধ UUID হতে হবে।',

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
            'rule-name' => 'কাস্টম-বার্তা',
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
