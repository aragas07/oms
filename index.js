var script = document.createElement("script")
script.id = "new-script"
document.body.append(script)
var link = document.createElement("link")
link.rel = "stylesheet"
link.id = "new-link"
document.head.append(link)
import routes from "./route/routes.js"
routes.nav();