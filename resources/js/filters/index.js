window.Vue.filter('truncate', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.length > 25 ? value.substr(0, 25) + '...' : value 
})
  
window.Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})