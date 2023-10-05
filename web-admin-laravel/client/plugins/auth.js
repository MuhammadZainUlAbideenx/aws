export default async function ({ app ,$auth, $axios, $gates }) {
  if (!$auth.loggedIn) {
    return
  }
  $auth.onRedirect((to, from) => {
    if(to == '/profile'){
      if($gates.hasRole('admin')){
        return app.localePath('/admin/dashboard')
      }
      else if($gates.hasRole('vendor')){
        return app.localePath('/vendor/dashboard')
      }
      else if($gates.hasRole('customer')){
        return app.localePath('/profile')
      }
      else{
        return app.localePath(to)
      }
    }
    return app.localePath(to)
   })
  $gates.setRoles($auth.user.roles)
  $gates.setPermissions($auth.user.permissions)
}
