export default {
    plugins: [
        {
            src: "~/plugins/axios",
            ssr: true
        },
        "~/plugins/auth.js"
    ],
    redirect: {
        home: false,
        login: "/login",
        logout: false,
        callback: false
    },
    cookie: {
        name: "token",
        options: {
            path: "/",
            secure: false
        }
    },
    strategies: {
        customer: {
            scheme: "local",
            token: {
                property: "data.token",
                required: true,
                type: "Bearer"
            },
            user: {
                property: "data",
                autoFetch: true
            },
            endpoints: {
                login: {
                    url: "/backend/api/customer/auth/login",
                    method: "post"
                },
                logout: {
                    url: "/backend/api/customer/auth/logout",
                    method: "get"
                },
                user: {
                    url: "/backend/api/customer/auth/user",
                    method: "get"
                }
            }
        },
        admin: {
            scheme: "local",
            token: {
                property: "data.token",
                required: true,
                type: "Bearer"
            },
            user: {
                property: "data",
                autoFetch: true
            },
            endpoints: {
                login: {
                    url: "/backend/api/admin/auth/login",
                    method: "post"
                },
                logout: {
                    url: "/backend/api/admin/auth/logout",
                    method: "get"
                },
                user: {
                    url: "/backend/api/admin/auth/user",
                    method: "get"
                }
            }
        },
        vendor: {
            scheme: "local",
            token: {
                property: "data.token",
                required: true,
                type: "Bearer"
            },
            user: {
                property: "data",
                autoFetch: true
            },
            endpoints: {
                login: {
                    url: "/backend/api/vendor/auth/login",
                    method: "post"
                },
                logout: {
                    url: "/backend/api/vendor/auth/logout",
                    method: "get"
                },
                user: {
                    url: "/backend/api/vendor/auth/user",
                    method: "get"
                }
            }
        },
        facebook: {
            clientId: process.env.SOCIAL_LOGIN_FACEBOOK_CLIENT_ID,
            redirectUri: process.env.APP_URL+"verify_login"
        },
        google: {
            clientId: process.env.SOCIAL_LOGIN_GOOGLE_CLIENT_ID,
            codeChallengeMethod: "",
            redirectUri: process.env.APP_URL+"verify_login"
        },
        customerSocialLogin: {
            scheme: "local",
            token: {
                property: "data.token",
                required: true,
                type: "Bearer"
            },
            user: {
                property: "data",
                autoFetch: true
            },
            endpoints: {
                login: {
                    url: "/backend/api/customer/auth/socialLogin",
                    method: "post"
                },
                logout: {
                    url: "/backend/api/customer/auth/logout",
                    method: "get"
                },
                user: {
                    url: "/backend/api/customer/auth/user",
                    method: "get"
                }
            }
        }
    }
}
