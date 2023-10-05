require('dotenv').config()
const { join } = require('path')
const { copySync, removeSync } = require('fs-extra')
var md5 = require('md5');
const fs = require('fs')
const path = require('path')
const localeConfigurations = require('./configurations/locales.json')
import authConfigurations from "./configurations/auth.js";

var sha256 = require('js-sha256');
import webpack from 'webpack'
module.exports = {
    ssr: false, // Comment this for SSR
    srcDir: __dirname,
    components: true,
    components: {
        dirs: [
            {
                path: '~/components/admin/',
                prefix: 'Admin'
            },
            {
                path: '~/components/admin/Skeleton-Loader',
                prefix: 'Admin'
            },
            {
                path: '~/components/seller/',
                prefix: 'Seller'
            },
            {
                path: '~/components/seller/Skeleton-Loader',
                prefix: 'Seller'
            },
            {
                path: '~/components/website/template1',
                prefix: 'WebsiteTemplate1'
            },
            {
                path: '~/components/website/template2',
                prefix: 'WebsiteTemplate2'
            },
            {
                path: '~/components/website/GlobalComponents',
                prefix: 'WebsiteGlobalComponents'
            },
            {
                path: '~/components/website/Cards/template1',
                prefix: 'Template1'
            },
            {
                path: '~/components/website/Cards/template2',
                prefix: 'Template2'
            },
            {
                path: '~/components/website/OrderFormSteps/Template1',
                prefix: 'WebsiteOrderFormStepsTemplate1'
            },
            {
                path: '~/components/website/OrderFormSteps/Template2',
                prefix: 'WebsiteOrderFormStepsTemplate2'
            },
            {
                path: '~/components/global/',
                prefix: 'Global'
            },
            {
                path: '~/components/website/skeleton/template1',
                prefix: 'WebsiteSkeletonTemplate1'
            },
            {
                path: '~/components/website/skeleton/template2',
                prefix: 'WebsiteSkeletonTemplate2'
            },
            {
                path: '~/components/website/HeaderLayouts',
                prefix: 'WebsiteHeaderLayouts'
            },
            {
                path: '~/components/website/FooterLayouts',
                prefix: 'WebsiteFooterLayouts'
            },
            {
                path: '~/components/website/CategorySmartBannerLayouts',
                prefix: 'WebsiteCategorySmartBannerLayouts'
            },
            {
                path: '~/components/website/ProductCardLayouts',
                prefix: 'WebsiteProductCardLayouts'
            },
        ]
    },
    env: {
        apiUrl: process.env.API_URL || process.env.APP_URL + '/api',
        appName: process.env.APP_NAME || 'Laravel Nuxt',
        appLocale: process.env.APP_LOCALE || 'en',
    },

    head: {
        title: process.env.APP_NAME,
        titleTemplate: '%s - ' + process.env.APP_NAME,
        meta: [
            { name: 'viewport', content: 'width=device-width, initial-scale=1' },
            { hid: 'description', name: 'description', content: 'Nuxt.js project' }
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: process.env.APP_URL+'/favicon.png' },
            { rel: 'stylesheet', href: 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css' }
        ],
        script: [{ src: `https://maps.googleapis.com/maps/api/js?key=${process.env.GOOGLE_MAP_API_KEY}&libraries=places`}],
    },
    css: [
    ],
    router: {
        middleware: ['auth', 'defaultLanguageCurrency']
    },
    loading: {
        color: 'blue',
        height: '5px'
    },
    toast: {
        duration: 1500,
        keepOnHover: true,
        theme: 'outline',
    },
    loadingIndicator: {
        name: 'components/website/template1/nictus-loader.html',
    },

    publicRuntimeConfig: {
        apiURL: process.env.API_URL,
        PUSHER_APP_CHANNEL_NAME:process.env.PUSHER_APP_CHANNEL_NAME,
        PUSHER_APP_EVENT_NAME:process.env.PUSHER_APP_EVENT_NAME
    },
    privateRuntimeConfig: {
        apiId: process.env.PASSPORT_CLIENT_ID,
        apiSecret: process.env.PASSPORT_CLIENT_SECRET,

    },
    proxy: {
        '/backend': {
            target: process.env.API_URL,
        },

    },
    axios: {
        proxy: true,
        baseURL: process.env.API_URL,
        // withCredentials:true
        headers: {
            common: {
                'Consumer-Key': sha256.hmac('thankyou', md5(process.env.CONSUMER_KEY)),
                'Consumer-Secret': sha256.hmac('thankyou', md5(process.env.CONSUMER_SECRET))
            }
        }
    },


    plugins: [
        '~/plugins/vue-gates',
        { src: '~/plugins/apex-chart', mode: 'client' },
        '~plugins/fontawesome',
        '~/plugins/repository',
        '~/plugins/feather-icons',
        '~/plugins/clipboard',
        { src: '~plugins/bootstrap', mode: 'client' },
        '~/plugins/datatable',
        { src: '~/plugins/tooltip', mode: 'client' },
        '~/plugins/datetime',
        '~/plugins/slick-carousel',
        '~/plugins/vue-select',
        '~/plugins/data-init',
        '~/plugins/vee-validate',
        '~/plugins/vue-chat-scroll',
        { src: '~/plugins/countdown', mode: 'client' },
        { src: '~/plugins/googleAutoComplete', mode: 'client' },
        { src: '~/plugins/star-rating', mode: 'client' },
        { src: '~/plugins/i18n.js' },
        { src: "~/plugins/vClickOutside.js", ssr: false }
    ],

    modules: [
        '@nuxtjs/axios',
        '@nuxtjs/toast',
        '@nuxtjs/pwa',
        '@nuxtjs/proxy',
        '@nuxtjs/auth-next',
        'cookie-universal-nuxt',
        ['nuxt-i18n', localeConfigurations],
        ['@nuxtjs/sitemap', {
            hostname: 'https://example.com'
        }],
        'nuxt-validate',
        '@nuxtjs/axios',

        ['@nuxtjs/laravel-echo', {
            broadcaster: 'pusher',
            key: process.env.MIX_PUSHER_APP_KEY,
            cluster: process.env.MIX_PUSHER_APP_CLUSTER,
            forceTLS: true,
            disableStats: true,
            encrypted: true,
        }],
        [
            '@nuxtjs/firebase',
            {
                config: {
                    apiKey: process.env.FIREBASE_API_KEY,
                    authDomain: process.env.FIREBASE_AUTH_DOMAIN,
                    projectId: process.env.FIREBASE_PROJECT_ID,
                    storageBucket: process.env.FIREBASE_STORAGE_BUCKET,
                    messagingSenderId: process.env.FIREBASE_MESSAGING_SENDER_ID,
                    appId: process.env.FIREBASE_APP_ID,
                    measurementId: process.env.FIREBASE_MEASUREMENT_ID
                },
                services: {
                    messaging: {
                        createServiceWorker: true,
                        fcmPublicVapidKey: process.env.FIREBASE_MESSAGING_FCM_PUBLIC_VAPID_KEY, // OPTIONAL : Sets vapid key for FCM after initialization
                        // inject: fs.readFileSync(path.resolve(__dirname, './static/firebase-messaging-sw.js'))
                    }
                }
            }
        ]
    ],
    zendesk: {
        key: 'zLuVKF1hfIDVeXTLVNoUys1HZpdYtFiRNrp6MDpv',
        disabled: false,
        settings: {
          webWidget: {
            color: {
              theme: '#78a300'
            }
          }
        }
      },
    build: {
        extractCSS: false,
        transpile: ['bootstrap','scss', 'jquery'],
        splitChunks: {
            layouts: true
        },
        loaders: {
            imgUrl: {
                esModule: false
            }
        },
        plugins: [
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery',
            })
        ]
    },

    auth: authConfigurations,
    pwa: {
        workbox: {
            importScripts: [
                '/public/firebase-messaging-sw.js'
            ],
            autoRegister: true
        }
    },
    hooks: {
        generate: {
            done(generator) {
                // Copy dist files to public/_nuxt
                if (generator.nuxt.options.dev === false && generator.nuxt.options.mode === 'spa') {
                    const publicDir = join(generator.nuxt.options.rootDir, 'public', '_nuxt')
                    const firebaseMessagingSWDir = join(generator.nuxt.options.rootDir, 'public', 'firebase-messaging-sw.js')
                    removeSync(publicDir)
                    removeSync(firebaseMessagingSWDir)
                    copySync(join(generator.nuxt.options.generate.dir, '_nuxt'), publicDir)
                    copySync(join(generator.nuxt.options.generate.dir, 'firebase-messaging-sw.js'), firebaseMessagingSWDir)
                    copySync(join(generator.nuxt.options.generate.dir, '200.html'), join(publicDir, 'index.html'))
                    removeSync(generator.nuxt.options.generate.dir)
                }
            }
        }
    }
}
