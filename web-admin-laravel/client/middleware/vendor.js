export default ({ $auth,$gates, redirect }) => {
  if($auth.loggedIn){
    if($gates.hasRole('vendor') && $auth.strategy.options.name == 'vendor'){

    }
    else{
      return redirect('/seller/login')
    }
  }
  else{
    return redirect('/seller/login')
  }
}
