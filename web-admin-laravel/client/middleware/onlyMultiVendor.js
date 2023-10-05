export default ({ app,$auth,$gates, redirect }) => {
    let is_multi_vendor = app.store.state.default_settings.general_settings.is_multi_vendor
  if(is_multi_vendor == 1){
  }
  else{
    return redirect('/admin/error_page')
  }
}
