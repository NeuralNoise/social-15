<div class="modal hide fade" id="reg">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h3>SignUp</h3>
    </div>
    <div class="modal-body">
        <form name="signup" id="signup" onsubmit="return false;">
            <div class="input-append input-prepend">
                <label for="username" class="add-on">Username: </label>
                <input type="text" name="username" id="username" onkeyup="restrict('username');" onfocus="emptyElement('regStatus')" onblur="checkUsername();"><span id="userStatus" class="add-on text-error"></span>
            </div>
            <div class="input-prepend input-append">
                <label for="password" class="add-on">Password: </label>
                <input type="password" name="password" id="password" onfocus="emptyElement('regStatus')" onblur="checkPass();"> <span id="pass2Status" class="add-on text-error"></span>            
            </div>
             <div class="input-append input-prepend">
                <label for="password2" class="add-on">Repeat Password: </label>
                <input type="password" name="password2" id="password2" onfocus="emptyElement('regStatus')" onblur="comparePass();"> <span id="passStatus" class="add-on"></span>            
            </div>
            <div class="input-append input-prepend">
                <label for="email" class="add-on">Email: </label>
                <input type="text" name="email" id="email" onkeyup="restrict('email');" onfocus="emptyElement('regStatus')" onblur="checkEmail();"><span id="emailStatus" class="add-on text-error"></span>
            </div>
            <div class="input-prepend">
                <label for="country" class="add-on">Select Your Country: </label>
                <select name="country" id="country">
                    <?php foreach ($countries as $country): ?>
                        <option value="<?= $country->country_id ?>"><?= $country->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input-prepend">
                <span class="add-on">Select Your Gender: </span>
                <div class="input-append">
                    <div class="btn-group" data-toggle="buttons-radio">
                        <button type="button" class="btn active">M</button>
                        <button type="button" class="btn">F</button>
                    </div>
                </div>
            </div>
            <div class="input-append input-prepend">
                <label class="add-on">Birthday: </label>
                <select name="day" id="day" class="input-small">
                    <option value="d">Day</option>    
                    <?php for ($i = 01; $i <= 31; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <select name="month" id="month" class="input-small">
                    <option value="m">Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <select name="year" id="year" class="input-small">
                    <option value="y">Year</option>    
                    <?php for ($i = date('Y') - 14; $i >= 1930; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>            
        </form>  
        <span id="regStatus" class="text-error"></span>
    </div>
    <div class="modal-footer">
        <button id="sub" onclick="reg();" class="btn btn-primary-lighten">Register</button>
    </div>
</div>