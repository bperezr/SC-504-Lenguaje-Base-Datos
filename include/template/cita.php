<aside class="sidebar contenido-principal">
    <form class="formulario" id="formulario">
        <fieldset>
            <h3 class="centrar-texto">Programar una cita</h3>
            <div class="contenedor-campos">
                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" placeholder="Nombre completo" id="nombre" name="nombre">
                </div>

                <div class="campo">
                    <label for="correo">Correo:</label>
                    <input type="email" placeholder="Correo electrónico" id="correo" name="correo">
                </div>

                <div class="campo">
                    <label for="mascota">Mascota:</label>
                    <select id="mascota" name="mascota">
                        <option value="" disabled selected>Seleccione la mascota</option>
                        <option value="Gato">Gato</option>
                        <option value="Perro">Perro</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="servicio">Servicio:</label>
                    <select id="servicio" name="servicio">
                        <option value="" disabled selected>Seleccione un servicio</option>
                        <option value="Medicina General">Medicina general</option>
                        <option value="Cirugía">Cirugía</option>
                        <option value="Castración">Castración</option>
                        <option value="Aseo de mascotas">Aseo de mascotas</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha">
                </div>

                <div class="campo">
                    <label for="horario">Horario:</label>
                    <select id="horario" name="horario">
                        <option value="" disabled selected>Seleccione un horario</option>
                        <option value="8:00 AM">8:00 AM</option>
                        <option value="10:00 AM">9:00 AM</option>
                        <option value="2:00 PM">10:00 AM</option>
                        <option value="4:00 PM">11:00 AM</option>
                        <option value="8:00 AM">1:00 PM</option>
                        <option value="10:00 AM">2:00 PM</option>
                        <option value="2:00 PM">3:00 PM</option>
                        <option value="4:00 PM">4:00 PM</option>
                    </select>
                </div>
            </div><!-- contenedor-campos -->

            <div class="boton-contacto">
                <input class="boton input-text" type="submit" value="Enviar">
            </div>

            <div class="contenedor-mensaje">
            </div>
        </fieldset>
    </form>
</aside>