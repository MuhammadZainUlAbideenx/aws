export default ({ $auth,$gates, redirect }) => {
  if($auth.loggedIn){
    if($gates.hasRole('customer') ){

    }
    else{
      return redirect('/login')
    }
  }
  else{
    return redirect('/login')
  }
}
