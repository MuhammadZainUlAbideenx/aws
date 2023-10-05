<template>
    <div>
     <div
            v-if="currentlyActiveTemplate == 'Template1'"
            class="row m-0 login-page"
        >
            <div class="col-md-7 px-0">
                <div class="login-wrapper px-4">
                    <div class="row h-100 mx-0 text-white position-relative">
                        <div
                            class="pt-5 pt-md-0 col-md-7 d-flex flex-column justify-content-md-center align-items-md-start"
                        >
                            <span class="top-level text-uppercase">
                                {{ $t("login.uper_heading") }}
                            </span>
                            <h1 class="text-start text-uppercase">
                                {{ $t("login.main_heading.text1") }}
                                <span class="text-white"
                                    >{{ $t("login.main_heading.text2") }}
                                </span>
                            </h1>
                            <p>
                                {{ $t("lorem_ipsum") }}
                            </p>
                        </div>
                        <div class="col-md-5 text-end">
                            <div class="position-absolute login-img">
                                <img
                                    src="~/assets/images/login-img.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="col-md-5 d-flex align-items-center justify-content-center"
            >
                <div class="login-slot pt-3">
                    <div class="text-center mb-2">
                        <GlobalLogo />
                    </div>
                    <ul
                        class="tab nav nav-pills mb-3 d-flex align-items-center justify-content-center"
                        id="pills-tab"
                        role="tablist"
                    >
                        <li
                            class="nav-item"
                            role="presentation"
                            @click="setDataVvScope('loginScope')"
                        >
                            <nuxt-link
                                to="#"
                                class="nav-link active"
                                id="pills-login-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#pills-login"
                                type="button"
                                role="tab"
                                aria-controls="pills-login"
                                aria-selected="true"
                            >
                                {{ $t("login.login") }}
                            </nuxt-link>
                        </li>
                        <li
                            class="nav-item"
                            role="presentation"
                            @click="setDataVvScope('registerScope')"
                        >
                            <nuxt-link
                                class="nav-link"
                                to="#"
                                id="pills-signup-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#pills-signup"
                                type="button"
                                role="tab"
                                aria-controls="pills-signup"
                                aria-selected="false"
                            >
                                {{ $t("login.signup") }}
                            </nuxt-link>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div
                            class="tab-pane fade active show"
                            id="pills-login"
                            role="tabpanel"
                            aria-labelledby="pills-login-tab"
                        >
                            <form @submit.prevent="loginPassport">
                                <div
                                    class="input-group mb-4 position-relative"
                                    :class="
                                        error &&
                                        error.errors &&
                                        error.errors.email
                                            ? 'error'
                                            : ''
                                    "
                                >
                                    <span
                                        v-if="
                                            error &&
                                            error.errors &&
                                            error.errors.email
                                        "
                                        class="d-flex justify-content-end"
                                    >
                                        <span
                                            class="text-danger position-absolute error-pos"
                                        >
                                            {{ error.errors.email[0] }}
                                        </span>
                                    </span>
                                    <div
                                        v-if="
                                            vErrors.has(
                                                'loginScope.login_email'
                                            )
                                        "
                                        class="d-flex justify-content-end"
                                        :show="true"
                                    >
                                        <span
                                            class="text-danger position-absolute error-pos"
                                        >
                                            {{
                                                vErrors.first(
                                                    "loginScope.login_email"
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <input
                                        type="email"
                                        id="LoggingEmailAddress"
                                        aria-describedby="emailHelp"
                                        class="shadow-sm form-control rounded-1 border-0"
                                        required
                                        v-model="formData.email"
                                        :placeholder="
                                            this.$t(
                                                'form.login.user_name.placeholder'
                                            )
                                        "
                                        data-vv-as="email"
                                        data-vv-name="login_email"
                                        v-validate="'required|email'"
                                        :state="
                                            vErrors.has('login_email')
                                                ? false
                                                : null
                                        "
                                        data-vv-scope="loginScope"
                                    />
                                    <div
                                        class="input-group-text custom-icon border-0 bg-transparent"
                                    >
                                        <div class="text-primary">
                                            <fa
                                                :icon="['fas', 'user']"
                                                fixed-width
                                                class=""
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="input-group mb-4 position-relative"
                                    :class="
                                        error &&
                                        error.errors &&
                                        error.errors.password
                                            ? 'error'
                                            : ''
                                    "
                                >
                                    <span
                                        v-if="
                                            error &&
                                            error.errors &&
                                            error.errors.password
                                        "
                                        class="d-flex justify-content-end"
                                    >
                                        <span
                                            class="text-danger position-absolute error-pos"
                                        >
                                            {{ error.errors.password[0] }}
                                        </span>
                                    </span>

                                    <div
                                        v-if="
                                            vErrors.has(
                                                'loginScope.login_password'
                                            )
                                        "
                                        class="d-flex justify-content-end"
                                        :show="true"
                                    >
                                        <span
                                            class="text-danger position-absolute error-pos"
                                        >
                                            {{
                                                vErrors.first(
                                                    "loginScope.login_password"
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <input
                                        :type="loginPasswordType"
                                        id="loggingPassword"
                                        class="shadow-sm form-control rounded-1 border-0"
                                        required
                                        v-model="formData.password"
                                        :placeholder="
                                            this.$t(
                                                'form.login.password.placeholder'
                                            )
                                        "
                                        v-validate="'required|min:8'"
                                        data-vv-as="passwords"
                                        data-vv-name="login_password"
                                        :state="
                                            vErrors.has('login_password')
                                                ? false
                                                : null
                                        "
                                        data-vv-scope="loginScope"
                                    />
                                    <div
                                        class="input-group-text custom-icon border-0 bg-transparent"
                                    >
                                        <div
                                            class="text-primary"
                                            v-on:click="changeLoginPasswordType"
                                        >
                                            <fa
                                                :icon="['fas', 'key']"
                                                fixed-width
                                                class=""
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-between px-2 mb-4"
                                >
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="login"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="login"
                                        >
                                            {{ $t("login.remember_me") }}
                                        </label>
                                    </div>

                                    <div class="form-check pl-0">
                                        <nuxt-link
                                            :to="localePath('/forgot-password')"
                                            class="text-xs heebo-light text-decoration-none"
                                        >
                                            {{ $t("login.forgot_password") }}
                                        </nuxt-link>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button
                                        class="btn btn-warning"
                                        type="submit"
                                    >
                                        {{ $t("login.login") }}
                                    </button>
                                </div>
                            </form>
                            <div class="text-center my-3">
                                <span>
                                    {{ $t("login.already_account.label") }}
                                </span>
                                <span @click="openSignupTab">
                                    <nuxt-link
                                        to="#"
                                        class="text-decoration-none"
                                    >
                                        {{ $t("login.already_account.click") }}
                                    </nuxt-link>
                                </span>
                            </div>
                            <div class="separator">
                                {{ $t("login.already_account.or") }}
                            </div>
                            <div class="mt-3 text-center">
                                <p>{{ $t("login.social.heading") }}</p>
                                <div
                                    class="d-flex btn-div flex-column flex-md-row align-items-center justify-content-center mt-3"
                                >
                                    <button
                                        @click="loginWithGoogle"
                                        type="button"
                                        class="btn btn-labeled text-white google py-0 me-3 mb-3 mb-md-0"
                                    >
                                        <span class="btn-label">
                                            <fa
                                                :icon="['fab', 'google-plus-g']"
                                                fixed-width
                                            /> </span
                                        >{{ $t("login.social.google") }}
                                    </button>
                                    <button
                                        @click="loginWithFacebook"
                                        type="button"
                                        class="btn btn-labeled text-white facebook py-0"
                                    >
                                        <span class="btn-label"
                                            ><fa
                                                :icon="['fab', 'facebook-f']"
                                                fixed-width /></span
                                        >{{ $t("login.social.facebook") }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="tab-pane fade"
                            id="pills-signup"
                            role="tabpanel"
                            aria-labelledby="pills-signup-tab"
                        >
                            <div
                                class="input-group mb-4 position-relative"
                                :class="
                                    error && errors && errors.first_name
                                        ? 'error'
                                        : ''
                                "
                            >
                                <span
                                    v-if="
                                        error &&
                                        error.errors &&
                                        errors.first_name
                                    "
                                    class="d-flex justify-content-end"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{ errors.first_name[0] }}
                                    </span>
                                </span>

                                <div
                                    v-if="
                                        vErrors.has(
                                            'registerScope.register_name'
                                        )
                                    "
                                    class="d-flex justify-content-end"
                                    :show="true"
                                >
                                    <span class="text-danger error-pos">
                                        {{
                                            vErrors.first(
                                                "registerScope.register_name"
                                            )
                                        }}
                                    </span>
                                </div>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="shadow-sm form-control rounded-1 border-0"
                                        :placeholder="
                                            this.$t(
                                                'form.signup.user_name.placeholder'
                                            )
                                        "
                                        v-model="signUpData.first_name"
                                        v-validate="'required|alpha_spaces'"
                                        data-vv-as="Name"
                                        data-vv-name="register_name"
                                        :state="
                                            vErrors.has('register_name')
                                                ? false
                                                : null
                                        "
                                        data-vv-scope="registerScope"
                                    />
                                    <div
                                        class="input-group-text custom-icon border-0 bg-transparent"
                                    >
                                        <div class="text-primary">
                                            <fa
                                                :icon="['fas', 'user']"
                                                fixed-width
                                                class=""
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="input-group mb-4 position-relative"
                                :class="
                                    error && errors && errors.email
                                        ? 'error'
                                        : ''
                                "
                            >
                                <span
                                    v-if="error && error && errors.email"
                                    class="d-flex justify-content-end"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{ errors.email[0] }}
                                    </span>
                                </span>
                                <div
                                    v-if="
                                        vErrors.has(
                                            'registerScope.register_email'
                                        )
                                    "
                                    class="d-flex justify-content-end"
                                    :show="true"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{
                                            vErrors.first(
                                                "registerScope.register_email"
                                            )
                                        }}
                                    </span>
                                </div>
                                <input
                                    type="email"
                                    class="shadow-sm form-control rounded-1 border-0"
                                    :placeholder="
                                        this.$t('form.signup.email.placeholder')
                                    "
                                    v-model="signUpData.email"
                                    v-validate="'required|email'"
                                    data-vv-as="Email"
                                    data-vv-name="register_email"
                                    :state="
                                        vErrors.has('register_email')
                                            ? false
                                            : null
                                    "
                                    data-vv-scope="registerScope"
                                />
                                <div
                                    class="input-group-text custom-icon border-0 bg-transparent"
                                >
                                    <div class="text-primary">
                                        <fa
                                            :icon="['fas', 'envelope']"
                                            fixed-width
                                            class=""
                                        />
                                    </div>
                                </div>
                            </div>

                            <div
                                class="input-group mb-4 position-relative"
                                :class="
                                    error && errors && errors.password
                                        ? 'error'
                                        : ''
                                "
                            >
                                <div
                                    v-if="
                                        vErrors.has(
                                            'registerScope.register_password'
                                        )
                                    "
                                    class="d-flex justify-content-end"
                                    :show="true"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{
                                            vErrors.first(
                                                "registerScope.register_password"
                                            )
                                        }}
                                    </span>
                                </div>
                                <span
                                    v-if="error && errors && errors.password"
                                    class="d-flex justify-content-end"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{ errors.password[0] }}
                                    </span>
                                </span>
                                <input
                                    :type="signUpPasswordType"
                                    class="shadow-sm form-control rounded-1 border-0"
                                    :placeholder="
                                        this.$t(
                                            'form.signup.password.placeholder'
                                        )
                                    "
                                    v-model="signUpData.password"
                                    v-validate="'required|min:8'"
                                    ref="password"
                                    data-vv-as="Password"
                                    data-vv-name="register_password"
                                    :state="
                                        vErrors.has('register_password')
                                            ? false
                                            : null
                                    "
                                    data-vv-scope="registerScope"
                                />
                                <div
                                    class="input-group-text custom-icon border-0 bg-transparent"
                                >
                                    <div
                                        class="text-primary"
                                        v-on:click="changeSignUpPasswordType"
                                    >
                                        <fa
                                            :icon="['fas', 'key']"
                                            fixed-width
                                            class=""
                                        />
                                    </div>
                                </div>
                            </div>

                            <div
                                class="input-group mb-3 position-relative"
                                :class="
                                    error &&
                                    errors &&
                                    errors.password_confirmation
                                        ? 'error'
                                        : ''
                                "
                            >
                                <div
                                    v-if="
                                        vErrors.has(
                                            'registerScope.register_confirm_password'
                                        )
                                    "
                                    class="d-flex justify-content-end"
                                    :show="true"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{
                                            vErrors.first(
                                                "registerScope.register_confirm_password"
                                            )
                                        }}
                                    </span>
                                </div>
                                <span
                                    v-if="error && errors && errors.password"
                                    class="d-flex justify-content-end"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{ errors.password[0] }}
                                    </span>
                                </span>
                                <input
                                    :type="signUpConfirmPasswordType"
                                    class="shadow-sm form-control rounded-1 border-0"
                                    :placeholder="
                                        this.$t(
                                            'form.signup.confirm_password.placeholder'
                                        )
                                    "
                                    v-model="signUpData.password_confirmation"
                                    v-validate="'required|confirmed:password'"
                                    data-vv-as="Confirm Password"
                                    data-vv-name="register_confirm_password"
                                    :state="
                                        vErrors.has('register_confirm_password')
                                            ? false
                                            : null
                                    "
                                    data-vv-scope="registerScope"
                                />
                                <div
                                    class="input-group-text custom-icon border-0 bg-transparent"
                                >
                                    <div
                                        class="text-primary"
                                        v-on:click="
                                            changeSignUpConfirmPasswordType
                                        "
                                    >
                                        <fa
                                            :icon="['fas', 'key']"
                                            fixed-width
                                            class=""
                                        />
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-start px-2 mb-3"
                            >
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        id="login"
                                    />
                                    <label class="form-check-label" for="login">
                                        {{ $t("signup.remember_me") }}</label
                                    >
                                </div>
                            </div>
                            <div class="d-grid">
                                <button
                                    class="btn btn-warning"
                                    type="button"
                                    @click="register"
                                >
                                    {{ $t("signup.signup") }}
                                </button>
                            </div>
                            <div class="text-center mt-3 mb-1">
                                <span>{{
                                    $t("signup.already_account.label")
                                }}</span>
                                <span @click="openLoginTab">
                                    <a href="#" class="text-decoration-none">{{
                                        $t("signup.login")
                                    }}</a></span
                                >
                            </div>
                            <div class="separator">
                                {{ $t("signup.already_account.or") }}
                            </div>
                            <div class="my-2 text-center">
                                <p>{{ $t("signup.social.heading") }}</p>
                                <div
                                    class="d-flex flex-column flex-md-row align-items-center justify-content-center mt-3"
                                >
                                    <button
                                        @click="loginWithGoogle"
                                        type="button"
                                        class="btn btn-div btn-labeled text-white google py-0 me-md-3 mb-3 mb-md-0"
                                    >
                                        <span class="btn-label">
                                            <fa
                                                :icon="['fab', 'google-plus-g']"
                                                fixed-width
                                            /> </span
                                        >{{ $t("signup.social.google") }}
                                    </button>
                                    <button
                                        @click="loginWithFacebook"
                                        type="button"
                                        class="btn btn-labeled text-white facebook py-0"
                                    >
                                        <span class="btn-label"
                                            ><fa
                                                :icon="['fab', 'facebook-f']"
                                                fixed-width /></span
                                        >{{ $t("signup.social.facebook") }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="currentlyActiveTemplate == 'Template2'">
            <div class="container-fluid signin">
                <div class="row d-flex align-items-center">
                    <div
                        class="col-lg-6 py-lg-0 py-5 signin-slider d-flex justify-content-center flex-column h-100"
                    >
                        <div class="px-lg-3 px-2 logo"><GlobalLogo /></div>

                        <VueSlickCarousel :key="key" v-bind="settings" class="my-5">
                            <div class="px-lg-3 px-2 ">
                                <img
                                    src="~/assets/images/login1.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="px-lg-3 px-2 ">
                                <img
                                    src="~/assets/images/login2.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="px-lg-3 px-2 ">
                                <img
                                    src="~/assets/images/login1.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="px-lg-3 px-2 ">
                                <img
                                    src="~/assets/images/login2.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                        </VueSlickCarousel>
                        <p class="mt-5 px-lg-3 px-2">{{$t('login.login_description')}}</p>
                    </div>
                    <div
                        class="col-lg-6 py-5 signin-form d-flex justify-content-center flex-column h-100"
                    >
                        <h2 class="text-primary mb-5">{{$t('welcome_back')}}</h2>

                        <form @submit.prevent="loginPassport">
                            <div
                                class="input-group mb-5 position-relative"
                                :class="
                                    error && error.errors && error.errors.email
                                        ? 'error'
                                        : ''
                                "
                            >
                                <span
                                    v-if="
                                        error &&
                                        error.errors &&
                                        error.errors.email
                                    "
                                    class="d-flex justify-content-end"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{ error.errors.email[0] }}
                                    </span>
                                </span>
                                <div
                                    v-if="vErrors.has('loginScope.login_email')"
                                    class="d-flex justify-content-end"
                                    :show="true"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{
                                            vErrors.first(
                                                "loginScope.login_email"
                                            )
                                        }}
                                    </span>
                                </div>
                                <input
                                    type="email"
                                    id="LoggingEmailAddress"
                                    aria-describedby="emailHelp"
                                    class="shadow-sm form-control rounded-1 border-0"
                                    required
                                    v-model="formData.email"
                                    :placeholder="
                                        this.$t(
                                            'form.login.user_name.placeholder'
                                        )
                                    "
                                    data-vv-as="email"
                                    data-vv-name="login_email"
                                    v-validate="'required|email'"
                                    :state="
                                        vErrors.has('login_email')
                                            ? false
                                            : null
                                    "
                                    data-vv-scope="loginScope"
                                />
                                <div
                                    class="input-group-text custom-icon border-0 bg-transparent"
                                >
                                    <div class="text-primary fs-5">
                                        <fa
                                            :icon="['fas', 'user']"
                                            fixed-width
                                            class=""
                                        />
                                    </div>
                                </div>
                            </div>

                            <div
                                class="input-group mb-4 position-relative"
                                :class="
                                    error &&
                                    error.errors &&
                                    error.errors.password
                                        ? 'error'
                                        : ''
                                "
                            >
                                <span
                                    v-if="
                                        error &&
                                        error.errors &&
                                        error.errors.password
                                    "
                                    class="d-flex justify-content-end"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{ error.errors.password[0] }}
                                    </span>
                                </span>

                                <div
                                    v-if="
                                        vErrors.has('loginScope.login_password')
                                    "
                                    class="d-flex justify-content-end"
                                    :show="true"
                                >
                                    <span
                                        class="text-danger position-absolute error-pos"
                                    >
                                        {{
                                            vErrors.first(
                                                "loginScope.login_password"
                                            )
                                        }}
                                    </span>
                                </div>
                                <input
                                    :type="loginPasswordType"
                                    id="loggingPassword"
                                    class="shadow-sm form-control rounded-1 border-0"
                                    required
                                    v-model="formData.password"
                                    :placeholder="
                                        this.$t(
                                            'form.login.password.placeholder'
                                        )
                                    "
                                    v-validate="'required|min:8'"
                                    data-vv-as="passwords"
                                    data-vv-name="login_password"
                                    :state="
                                        vErrors.has('login_password')
                                            ? false
                                            : null
                                    "
                                    data-vv-scope="loginScope"
                                />
                                <div
                                    class="input-group-text custom-icon border-0 bg-transparent"
                                >
                                    <div
                                        class="text-primary fs-5"
                                        v-on:click="changeLoginPasswordType"
                                    >
                                        <fa
                                            :icon="['fas', 'key']"
                                            fixed-width
                                            class=""
                                        />
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between px-2 mb-4"
                            >
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input bg-transparent"
                                        id="login"
                                    />
                                    <label
                                        class="form-check-label text-muted"
                                        for="login"
                                    >
                                        {{ $t("login.remember_me") }}
                                    </label>
                                </div>

                                <div class="form-check pl-0">
                                    <nuxt-link
                                        :to="localePath('/forgot-password')"
                                        class="text-xs text-primary text-decoration-none"
                                    >
                                        {{ $t("login.forgot_password") }}
                                    </nuxt-link>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button
                                    class="btn btn-primary d-flex justify-content-center align-items-center text-uppercase text-white fw-bold shadow-lg"
                                    type="submit"
                                >
                                    {{ $t("login.login") }}
                                </button>
                            </div>
                        </form>
                        <div class="text-center mb-3 mt-5 fw-bold">
                            <span>
                                {{ $t("login.already_account.label") }}
                            </span>
                            <span>
                                <nuxt-link
                                    to="/signup"
                                    class="text-primary text-decoration-none"
                                >
                                    {{ $t("login.already_account.click") }}
                                </nuxt-link>
                            </span>
                        </div>
                        <hr />

                        <div class="mt-3 text-center">
                            <div
                                class="d-flex btn-div flex-column flex-md-row align-items-center justify-content-center mt-3"
                            >
                                <button
                                    @click="loginWithGoogle"
                                    type="button"
                                    class="btn btn-labeled text-white google py-0 me-3 mb-3 mb-md-0"
                                >
                                    <span class="btn-label">
                                        <fa
                                            :icon="['fab', 'google-plus-g']"
                                            fixed-width
                                        /> </span
                                    >{{ $t("login.social.google") }}
                                </button>
                                <button
                                    @click="loginWithFacebook"
                                    type="button"
                                    class="btn btn-labeled text-white facebook py-0"
                                >
                                    <span class="btn-label"
                                        ><fa
                                            class="text-white"
                                            :icon="['fab', 'facebook-f']"
                                            fixed-width /></span
                                    >{{ $t("login.social.facebook") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    layout: "default_guest",
    auth: false,
    data() {
        return {
            settings: {
                slidesToShow: 2,
                slidesToScroll:1,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            arrows: false,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                        },
                    },

                ],
            },
            currentlyActiveTemplate: "",
            signUpData: {
                first_name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
            formData: {
                email: "",
                password: "",
                strategy: "customer",
            },
            error: null,
            errors: "",
            fcmToken: "",
            uid: "",
            validatorScop: "loginScope",
            loginPasswordType: "password",
            signUpPasswordType: "password",
            signUpConfirmPasswordType: "password",
        };
    },
    created() {

        this.currentlyActiveTemplate =
            this.allSettings.general_settings.currently_active_theme;
    },
    mounted() {
        if (
            this.allSettings &&
            this.allSettings.general_settings &&
            this.allSettings.general_settings.is_notification_activated &&
            this.allSettings.general_settings.is_notification_activated == 1
        ) {
            if (Notification.permission == "granted") {
                this.generateFcmTokenAndUid();
            }
        }
    },
    computed: {
        ...mapGetters({
            allSettings: "allDefaultSettings",
        }),
    },
    methods: {
        async generateFcmTokenAndUid() {
            this.fcmToken = await this.$fire.messaging.getToken();
            var navigator_info = window.navigator;
            var screen_info = window.screen;
            var uid = navigator_info.mimeTypes.length;
            uid += navigator_info.userAgent.replace(/\D+/g, "");
            uid += navigator_info.plugins.length;
            uid += screen_info.height || "";
            uid += screen_info.width || "";
            uid += screen_info.pixelDepth || "";
            this.uid = uid;
        },
        ...mapActions({
            fetchWishlistItems: "Web/Wishlist/fetchWishlistItems",
            fetchCartItems: "Web/Cart/fetchCartItems",
            fetchCompareProducts: "Web/General/fetchCompareProducts",
        }),
        async register() {
            this.error = null;

            this.$validator
                .validateAll(this.validatorScop)
                .then(async (valid) => {
                    if (valid) {
                        await this.$webService
                            .registerCustomer(this.signUpData)
                            .then(async () => {
                                this.$toast.success(
                                    this.$t('your_account_created_successfully')
                                );
                                await this.autoLoginAfterSignup();
                            })
                            .catch((error) => {
                                this.error = true;
                                this.errors = error.response.data.errors;
                            });
                    }
                });
        },
        async loginPassport() {
            this.error = null;
            await this.logoutOtherAccounts();
            this.$validator
                .validateAll(this.validatorScop)
                .then(async (valid) => {
                    if (valid) {
                        await this.$auth
                            .loginWith("customer", { data: this.formData })
                            .then(async () => {
                                await this.$gates.setRoles(
                                    this.$auth.user.roles
                                );
                                await this.$gates.setPermissions(
                                    this.$auth.user.permissions
                                );
                                await this.fetchCartItems();
                                if (
                                    this.allSettings &&
                                    this.allSettings.general_settings &&
                                    this.allSettings.general_settings
                                        .is_notification_activated &&
                                    this.allSettings.general_settings
                                        .is_notification_activated == 1
                                ) {
                                    if (Notification.permission == "granted") {
                                        await this.storeFcmToken();
                                    }
                                }
                                localStorage.removeItem("compare_products");
                                this.fetchCompareProductsAfterLogin();
                                this.$router.replace("/");
                                this.$toast.success(this.$t('you_have_been_logged_in'));
                            })
                            .catch((e) => {
                                this.error = e.response.data;
                                this.$toast.error(
                                    this.$t('you_email_password_wrong')
                                );
                            });
                    }
                });
        },
        async autoLoginAfterSignup() {
            await this.logoutOtherAccounts();

            localStorage.removeItem("compare_products");
            this.fetchCompareProductsAfterLogin();
            this.formData.email = this.signUpData.email;
            this.formData.password = this.signUpData.password;
            this.error = null;
            await this.$auth
                .loginWith("customer", { data: this.formData })
                .then(async () => {
                    await this.$gates.setRoles(this.$auth.user.roles);
                    await this.$gates.setPermissions(
                        this.$auth.user.permissions
                    );
                    await this.fetchCartItems();
                    if (
                        this.allSettings &&
                        this.allSettings.general_settings &&
                        this.allSettings.general_settings
                            .is_notification_activated &&
                        this.allSettings.general_settings
                            .is_notification_activated == 1
                    ) {
                        if (Notification.permission == "granted") {
                            await this.storeFcmToken();
                        }
                    }
                    this.$router.replace("/");
                    this.$toast.success(this.$t('you_have_been_logged_in'));
                })
                .catch((e) => (this.error = e.response.data));
        },
        async storeFcmToken() {
            const { data } = await this.$webService.storeFcmToken({
                device_id: this.uid,
                fcm_token: this.fcmToken,
            });
        },
        async loginWithFacebook() {
            await this.logoutOtherAccounts();
            if (process.client) {
                localStorage.setItem("social_login_type", "facebook");
            }
            await this.$auth.loginWith("facebook");
        },
        async loginWithGoogle() {
            await this.logoutOtherAccounts();
            if (process.client) {
                localStorage.setItem("social_login_type", "google");
            }
            await this.$auth.loginWith("google");
        },
        openSignupTab() {
            this.validatorScop = "registerScope";
            var tab = document.getElementById("pills-login");
            tab.classList.remove("active", "show");
            tab = document.getElementById("pills-signup");
            tab.classList.add("active", "show");
            tab = document.getElementById("pills-signup-tab");
            tab.classList.add("active");
            var tab = document.getElementById("pills-login-tab");
            tab.classList.remove("active");
        },
        openLoginTab() {
            this.validatorScop = "loginScope";
            var tab = document.getElementById("pills-login");
            tab.classList.add("active", "show");
            tab = document.getElementById("pills-signup");
            tab.classList.remove("active", "show");
            var tab = document.getElementById("pills-login-tab");
            tab.classList.add("active");
            tab = document.getElementById("pills-signup-tab");
            tab.classList.remove("active");
        },
        setDataVvScope(value) {
            this.validatorScop = value;
        },
        async fetchCompareProductsAfterLogin() {
            var get_compare_products = JSON.parse(
                localStorage.getItem("compare_products")
            );
            await this.fetchCompareProducts({
                compare_ids: get_compare_products,
            });
        },
        changeLoginPasswordType() {
            if (this.loginPasswordType === "password") {
                this.loginPasswordType = "text";
            } else {
                this.loginPasswordType = "password";
            }
        },
        changeSignUpPasswordType() {
            if (this.signUpPasswordType === "password") {
                this.signUpPasswordType = "text";
            } else {
                this.signUpPasswordType = "password";
            }
        },
        changeSignUpConfirmPasswordType() {
            if (this.signUpConfirmPasswordType === "password") {
                this.signUpConfirmPasswordType = "text";
            } else {
                this.signUpConfirmPasswordType = "password";
            }
        },
        async logoutOtherAccounts() {
            await this.$auth.logout();
            await this.$gates.setRoles([]);
            await this.$gates.setPermissions([]);
        },
    },
    watch: {
        formData: {
            handler(val, oldVal) {
                if ((this.error = null)) {
                    this.error = null;
                    this.errors = "";
                }
            },
            deep: true,
        },
        signUpData: {
            handler(val, oldVal) {
                if ((this.error = null)) {
                    this.error = null;
                    this.errors = "";
                }
            },
            deep: true,
        },
    },
};
</script>
