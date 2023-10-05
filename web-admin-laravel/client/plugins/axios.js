export default async function ({store, $auth, $axios, redirect, $gates, app,$config}) {
  $axios.onError(error => {
    if(error.response.status === 500) {
      // if ($auth.loggedIn && $gates.hasRole('admin')) {
      //   redirect(app.localePath('/admin/sorry'))
      // }
      // else{
      //   redirect(app.localePath('/sorry'))
      // }
    }
    else if(error.response.status === 403) {
      app.$toast.error("You Are Not Authenticated To Perform This Action")
    }
  })
  // $axios.setHeader('Consumer-Key', $config.consumerKey)
  // $axios.setHeader('Consumer-Secret', $config.consumerSecret)

  $axios.onRequest((config) => {
     // config.headers.common['Consumer-Key'] = $config.consumerKey
     // config.headers.common['Consumer-Secret'] = $config.consumerSecret
   })
}
