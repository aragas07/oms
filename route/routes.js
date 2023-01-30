export default{
    nav
}
const urlRoutes = {
    404:{template: "templates/404.html", title: "Page not found", script: "login"},
    "/": {template: "templates/login.html", title:"Login | OMS", script: "login"},
    "/about": {template: "templates/about.html", title:"About | OMS", script: ""},
    "/contact": {template: "templates/contact.html", title:"contact |OMS", script: ""},
    "/login": {template: "route/login", title:"",script:""},
}

function nav(){
    document.addEventListener('click',(e)=>{
        const{target} = e
        if(!target.matches("nav a")){
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

const urlLocationHandler = async()=>{
    const location = window.location.pathname
    if(location.length == 0){
        location = "/"
    }
    const route = urlRoutes[location] || urlRoutes[404]
    const html = await fetch(route.template).then((response) => response.text()) 
    document.getElementById("component").innerHTML = html
    document.title = route.title
    var script = document.getElementById("new-script")
    script.src = "assets/js/"+route.script+".js"
}

window.onpopstate = urlLocationHandler
window.route = urlRoute
urlLocationHandler()