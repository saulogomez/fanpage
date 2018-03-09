<form class="reserva-contacto" method="post">
  <h2> Realiza una Reservacion </h2>
  <div class="campo">
    <input type="text" name="nombre" placeholder="Nombre" required>
  </div>
  <div class="campo">
    <input type="datetime-local" name="fecha" placeholder="Fecha" step="300" required>
  </div>
  <div class="campo">
    <input type="email" name="correo" placeholder="Correo" required>
  </div>
  <div class="campo">
    <input type="tel" name="telefono" placeholder="Telefono" required>
  </div>
  <div class="campo">
    <textarea  name="mensaje" placeholder="mensaje" required>  </textarea>
  </div>

  <div class="g-recaptcha" data-sitekey="6LdiY0sUAAAAABdnVsQFcqHnooHN8dNDiA5pL9jX"></div>

  <input type="submit" name="enviar" class="button ">
  <input type="hidden" name="oculto" value="1">

</form>
