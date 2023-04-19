<fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?=s($propiedad->titulo);?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?=s($propiedad->precio);?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?=s($propiedad->descripcion);?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" min="1" max="9" value="<?=s($propiedad->habitaciones);?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc"  min="1" max="9" value="<?=s($propiedad->wc);?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" min="1" max="9" value="<?=s($propiedad->estacionamiento);?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
            </fieldset>