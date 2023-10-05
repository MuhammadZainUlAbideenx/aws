export default ({ $auth,$gates, redirect }) => {
  if($auth.loggedIn){
    if(($gates.hasRole('admin') || $gates.hasRole('super_admin')) && $auth.strategy.options.name == 'admin'){
    }
    else{
      return redirect('/admin/login')
    }
  }
  else{
    return redirect('/admin/login')
  }
}
