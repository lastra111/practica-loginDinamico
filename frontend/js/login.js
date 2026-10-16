/*
1. Esperamos a que la pagina este lista:
Esto garantiza que el codigo de javaScript se ejecute unicamente
cuando todo el html ha sido completamente descargado y procesado
por el navegador, sin importar si el script esta colocado en el <head> o al final 
*/ 
document.addEventListener('DOMContentLoaded', () => {
    const formLogin = document.getElementById('formLogin');
    const mensaje = document.getElementById('divMensaje');
    if (formLogin){
        //escuchamos estrictamente el events Submit del formulario
        formLogin.addEventListener('submit',async (e) => {
            //Evitamos que la pagina se recargue
            e.preventDefault();

            const usuario = document.getElementById('txtUsuario').value.trim();
            const password = document.getElementById('txtPassword').value.trim();
            
            //Comprobacion dinamica en fronted (ahorra peticiones innecesarias)
            if (usuario === "" || password === "") {
                mensaje.textContent = "Por favor llena todos los campos."
                return;
            }

            mensaje.textContent = "Procesando...";

            try {
                const respuesta = await fetch('../../backend/api/login-proceso.php',{
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({usuario,password })
                });

                const datos = await respuesta.json();

                if (datos.status === 'success') {
                    // El servidros nos dice a donde redirigir segun el rol
                    window.location.href = datos.redirect;
                } else {
                    mensaje.textContent = datos.message;
                }

            } catch (error) {
                mensaje.textContent = "Error al conectar al servidor";
                
            }


                } );
            }

});



/*
document.getElementById('formLogin').addEventListener('submit',async (e) => {
    e.preventDefault();//Detener el envio tradicional de html

    const usuario = document.getElementById('txtUsuario').value.trim();
    const password = document.getElementById('txtPassword').value.trim();
    const mensaje = document.getElementById('divMensaje');

    //Comprobacion dinamica en frinted (ahorra peticiones innecesarias)
    if (usuario === "" || password === "") {
        mensaje.textContent = "Por favor llena todos los campos."
        return;
    }

    mensaje.textContent = "Procesando...";

    try {
        const respuesta = await fetch('../../backend/api/login-proceso.php',{
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({usuario,password })
        });

        const datos = await respuesta.json();

        if (datos.status === 'success') {
            // El servidros nos dice a donde redirigir segun el rol
            window.location.href = datos.redirect;
        } else {
            mensaje.textContent = datos.message;
        }

    } catch (error) {
        mensaje.textContent = "Error al conectar al servidor";
        
    }
});
*/