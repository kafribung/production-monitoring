const Ziggy = {"url":"http:\/\/127.0.0.1:8000","port":8000,"defaults":{},"routes":{"filament.asset":{"uri":"filament\/assets\/{file}","methods":["GET","HEAD"],"wheres":{"file":".*"}},"filament.auth.logout":{"uri":"filament\/logout","methods":["POST"]},"filament.auth.login":{"uri":"admin\/login","methods":["GET","HEAD"]},"filament.pages.dashboard":{"uri":"admin","methods":["GET","HEAD"]},"filament.resources.categories.index":{"uri":"admin\/categories","methods":["GET","HEAD"]},"filament.resources.categories.create":{"uri":"admin\/categories\/create","methods":["GET","HEAD"]},"filament.resources.categories.edit":{"uri":"admin\/categories\/{record}\/edit","methods":["GET","HEAD"]},"filament.resources.colors.index":{"uri":"admin\/colors","methods":["GET","HEAD"]},"filament.resources.colors.create":{"uri":"admin\/colors\/create","methods":["GET","HEAD"]},"filament.resources.colors.edit":{"uri":"admin\/colors\/{record}\/edit","methods":["GET","HEAD"]},"filament.resources.materials.index":{"uri":"admin\/materials","methods":["GET","HEAD"]},"filament.resources.materials.create":{"uri":"admin\/materials\/create","methods":["GET","HEAD"]},"filament.resources.materials.edit":{"uri":"admin\/materials\/{record}\/edit","methods":["GET","HEAD"]},"filament.resources.products.index":{"uri":"admin\/products","methods":["GET","HEAD"]},"filament.resources.products.create":{"uri":"admin\/products\/create","methods":["GET","HEAD"]},"filament.resources.products.edit":{"uri":"admin\/products\/{record}\/edit","methods":["GET","HEAD"]},"filament.resources.sizes.index":{"uri":"admin\/sizes","methods":["GET","HEAD"]},"filament.resources.sizes.create":{"uri":"admin\/sizes\/create","methods":["GET","HEAD"]},"filament.resources.sizes.edit":{"uri":"admin\/sizes\/{record}\/edit","methods":["GET","HEAD"]},"filament.resources.users.index":{"uri":"admin\/users","methods":["GET","HEAD"]},"filament.resources.users.create":{"uri":"admin\/users\/create","methods":["GET","HEAD"]},"filament.resources.users.edit":{"uri":"admin\/users\/{record}\/edit","methods":["GET","HEAD"]},"livewire.message":{"uri":"livewire\/message\/{name}","methods":["POST"]},"livewire.upload-file":{"uri":"livewire\/upload-file","methods":["POST"]},"livewire.preview-file":{"uri":"livewire\/preview-file\/{filename}","methods":["GET","HEAD"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"home":{"uri":"\/","methods":["GET","HEAD"]},"product.show":{"uri":"product\/{product}","methods":["GET","HEAD"],"bindings":{"product":"slug"}},"register":{"uri":"register","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["GET","HEAD"]},"password.request":{"uri":"forgot-password","methods":["GET","HEAD"]},"password.email":{"uri":"forgot-password","methods":["POST"]},"password.reset":{"uri":"reset-password\/{token}","methods":["GET","HEAD"]},"password.update":{"uri":"reset-password","methods":["POST"]},"verification.notice":{"uri":"verify-email","methods":["GET","HEAD"]},"verification.verify":{"uri":"verify-email\/{id}\/{hash}","methods":["GET","HEAD"]},"verification.send":{"uri":"email\/verification-notification","methods":["POST"]},"password.confirm":{"uri":"confirm-password","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
