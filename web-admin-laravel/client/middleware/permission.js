export default ({ $auth,$gates,route,app, redirect}) => {
  if($auth.loggedIn){
    const permissions =  $gates.getPermissions();
    if(permissions.includes(route.meta[0].permission)){
    }
    else{
      if(process.client){
        app.$toast.error("not authenticated")
      }
        if(($gates.hasRole('admin') || $gates.hasRole('super_admin')) && $auth.strategy.options.name == 'admin'){
          redirect('/admin/dashboard')
        }
        else if($gates.hasRole('vendor') && $auth.strategy.options.name == 'vendor'){
          redirect('/seller/dashboard')
        }
        else if($gates.hasRole('customer') || $auth.strategy.options.name == 'customer'){
          redirect('/profile')
        }
        else{
          redirect('/login')
        }
      }
  }
}
