export default{
    nav
}
const urlRoutes = {
    404:{template: "templates/404.html", title: "Page not found", script: "login", link: ""},
    "/": {template: "templates/login.html", title:"Login | OMS", script: "login", link: "login"},
    "/home": {template: "templates/home.html", title: "Home | OMS", script: "home", link: "home"},
    "/about": {template: "templates/about.html", title:"About | OMS", script: "about", link: ""},
    "/contact": {template: "templates/contact.html", title:"contact | OMS", script: "", link: ""},
    "/signup": {template: "templates/signup.html",title:"Sign up | OMS",script: "signup", link:"login"},
    "/municipality": {template: "templates/municipal.html", title: sessionStorage.getItem('city')+" | OMS", script: "municipality", link: "home"},
    "/superadmin": {template: "templates/superadmin.html", title: "Super Admin", script: "superadmin", link: "home"}
}

window.addEventListener('click', function(){
    if(sessionStorage.length == 0){
        window.location.href = '/'
    }
})

function nav(){
    document.addEventListener("click",(e)=>{
        const {target} = e;
        if(!target.matches("a")){
            return
        }
        e.preventDefault()
        urlRoute()
    })
}
const urlRoute = (event)=>{
    event = event || window.event
    event.preventDefault()
    window.history.pushState({}, "",event.target.href)
    urlLocationHandler()
}
sessionStorage.setItem("auth","superadmin");
if(sessionStorage.length == 0){
    sessionStorage.setItem("auth","none");
}
const urlLocationHandler = async()=>{
    const location = window.location.pathname
    if(location.length == 0){
        location = "/"
    }else if(location == '/signup'){
    }else if(sessionStorage.getItem('auth') == 'none' && location.length > 1){
        window.location.href = "/"
    }
    const route = urlRoutes[location] || urlRoutes[404]
    const html = await fetch(route.template).then((response) => response.text())
    document.getElementById("new-link").href = "assets/css/"+route.link+".css"
    document.getElementById("component").innerHTML = html
    document.title = route.title
    var script = document.getElementById("new-script")
    script.src = "assets/js/"+route.script+".js"
}

window.onpopstate = urlLocationHandler
window.route = urlRoute
urlLocationHandler()