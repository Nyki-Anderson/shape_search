<?php if (isset($errors)) : ?>
    <div class='notify-error'>
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= esc($error); ?></li>
        <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<div class='form-container'>
    
    <?= form_open_multipart(route_to('edit_profile'), ['autocomplete' => FALSE]); ?>

        <div class='form-header'>
            <h2>Edit Profile</h2>
        </div>

        <div class='form-body'>

            <div class='form-row'>
                <div class='input-container'>
                    <i class='fa-solid fa-feather-pointed' title='About Me'></i>

                    <?php $attributes = [
                            'name'          => 'about_me',
                            'class'         => 'input-field',
                            'id'            => 'about_me',
                            'placeholder'   => 'Tell us about yourself',
                            'rows'          => '2',
                    ]; ?>
                    <?= form_textarea($attributes, !empty($profile->about_me)?$profile->about_me:''); ?>
                    
                </div>
            </div>

            <div class='form-row'>
                <div class='input-container'>
                    <i class="fa-solid fa-calendar-day" title='Birthday'></i>

                    <select class='input-field' name='bday_month' title='Birthday Month'>
                        <option value=''>Month</option>
                        <option value='01'<?php if (isset($profile->bday_month) && $profile->bday_month == '01') echo ('selected'); ?>>Jan</option>
                        <option value='02'<?php if (isset($profile->bday_month) && $profile->bday_month == '02') echo ('selected'); ?>>Feb</option>
                        <option value='03'<?php if (isset($profile->bday_month) && $profile->bday_month == '03') echo ('selected'); ?>>Mar</option>
                        <option value='04'<?php if (isset($profile->bday_month) && $profile->bday_month == '04') echo ('selected'); ?>>Apr</option>
                        <option value='05'<?php if (isset($profile->bday_month) && $profile->bday_month == '05') echo ('selected'); ?>>May</option>
                        <option value='06'<?php if (isset($profile->bday_month) && $profile->bday_month == '06') echo ('selected'); ?>>Jun</option>
                        <option value='07'<?php if (isset($profile->bday_month) && $profile->bday_month == '07') echo ('selected'); ?>>Jul</option>
                        <option value='08'<?php if (isset($profile->bday_month) && $profile->bday_month == '08') echo ('selected'); ?>>Aug</option>
                        <option value='09'<?php if (isset($profile->bday_month) && $profile->bday_month == '09') echo ('selected'); ?>>Sep</option>
                        <option value='10'<?php if (isset($profile->bday_month) && $profile->bday_month == '10') echo ('selected'); ?>>Oct</option>
                        <option value='11'<?php if (isset($profile->bday_month) && $profile->bday_month == '11') echo ('selected'); ?>>Nov</option>
                        <option value='12'<?php if (isset($profile->bday_month) && $profile->bday_month == '12') echo ('selected'); ?>>Dec</option>
                    </select>

                    <select class='input-field' name='bday_day' title='Birthday Day'>
                        <option value=''>Day</option>
                        <option value='01'<?php if (isset($profile->bday_day) && $profile->bday_day == '01') echo ('selected'); ?>>01</option>
                        <option value='02'<?php if (isset($profile->bday_day) && $profile->bday_day == '02') echo ('selected'); ?>>02</option>
                        <option value='03'<?php if (isset($profile->bday_day) && $profile->bday_day == '03') echo ('selected'); ?>>03</option>
                        <option value='04'<?php if (isset($profile->bday_day) && $profile->bday_day == '04') echo ('selected'); ?>>04</option>
                        <option value='05'<?php if (isset($profile->bday_day) && $profile->bday_day == '05') echo ('selected'); ?>>05</option>
                        <option value='06'<?php if (isset($profile->bday_day) && $profile->bday_day == '06') echo ('selected'); ?>>06</option>
                        <option value='07'<?php if (isset($profile->bday_day) && $profile->bday_day == '07') echo ('selected'); ?>>07</option>
                        <option value='08'<?php if (isset($profile->bday_day) && $profile->bday_day == '08') echo ('selected'); ?>>08</option>
                        <option value='09'<?php if (isset($profile->bday_day) && $profile->bday_day == '09') echo ('selected'); ?>>09</option>
                        <option value='10'<?php if (isset($profile->bday_day) && $profile->bday_day == '10') echo ('selected'); ?>>10</option>
                        <option value='11'<?php if (isset($profile->bday_day) && $profile->bday_day == '11') echo ('selected'); ?>>11</option>
                        <option value='12'<?php if (isset($profile->bday_day) && $profile->bday_day == '12') echo ('selected'); ?>>12</option>
                        <option value='13'<?php if (isset($profile->bday_day) && $profile->bday_day == '13') echo ('selected'); ?>>13</option>
                        <option value='14'<?php if (isset($profile->bday_day) && $profile->bday_day == '14') echo ('selected'); ?>>14</option>
                        <option value='15'<?php if (isset($profile->bday_day) && $profile->bday_day == '15') echo ('selected'); ?>>15</option>
                        <option value='16'<?php if (isset($profile->bday_day) && $profile->bday_day == '16') echo ('selected'); ?>>16</option>
                        <option value='17'<?php if (isset($profile->bday_day) && $profile->bday_day == '17') echo ('selected'); ?>>17</option>
                        <option value='18'<?php if (isset($profile->bday_day) && $profile->bday_day == '18') echo ('selected'); ?>>18</option>
                        <option value='19'<?php if (isset($profile->bday_day) && $profile->bday_day == '19') echo ('selected'); ?>>19</option>
                        <option value='20'<?php if (isset($profile->bday_day) && $profile->bday_day == '20') echo ('selected'); ?>>20</option>
                        <option value='21'<?php if (isset($profile->bday_day) && $profile->bday_day == '21') echo ('selected'); ?>>21</option>
                        <option value='22'<?php if (isset($profile->bday_day) && $profile->bday_day == '22') echo ('selected'); ?>>22</option>
                       <option value='23'<?php if (isset($profile->bday_day) && $profile->bday_day == '23') echo ('selected'); ?>>23</option>
                       <option value='24'<?php if (isset($profile->bday_day) && $profile->bday_day == '24') echo ('selected'); ?>>24</option>
                       <option value='25'<?php if (isset($profile->bday_day) && $profile->bday_day == '25') echo ('selected'); ?>>25</option>
                       <option value='26'<?php if (isset($profile->bday_day) && $profile->bday_day == '26') echo ('selected'); ?>>26</option>
                       <option value='27'<?php if (isset($profile->bday_day) && $profile->bday_day == '27') echo ('selected'); ?>>27</option>
                       <option value='28'<?php if (isset($profile->bday_day) && $profile->bday_day == '28') echo ('selected'); ?>>28</option>
                       <option value='29'<?php if (isset($profile->bday_day) && $profile->bday_day == '29') echo ('selected'); ?>>29</option>
                       <option value='30'<?php if (isset($profile->bday_day) && $profile->bday_day == '30') echo ('selected'); ?>>30</option>
                       <option value='31'<?php if (isset($profile->bday_day) && $profile->bday_day == '31') echo ('selected'); ?>>31</option>
                    </select>

                    <select class='input-field' name='bday_year' title='Birthday Year'>
                        <option value=''>Year</option>
                        <option value='2022'<?php if (isset($profile->bday_year) && $profile->bday_year == '2022') echo ('selected'); ?>>2022</option>
                        <option value='2021'<?php if (isset($profile->bday_year) && $profile->bday_year == '2021') echo ('selected'); ?>>2021</option>
                        <option value='2020'<?php if (isset($profile->bday_year) && $profile->bday_year == '2020') echo ('selected'); ?>>2020</option>
                        <option value='2019'<?php if (isset($profile->bday_year) && $profile->bday_year == '2019') echo ('selected'); ?>>2019</option>
                        <option value='2018'<?php if (isset($profile->bday_year) && $profile->bday_year == '2018') echo ('selected'); ?>>2018</option>
                        <option value='2017'<?php if (isset($profile->bday_year) && $profile->bday_year == '2017') echo ('selected'); ?>>2017</option>
                        <option value='2016'<?php if (isset($profile->bday_year) && $profile->bday_year == '2016') echo ('selected'); ?>>2016</option>
                        <option value='2015'<?php if (isset($profile->bday_year) && $profile->bday_year == '2015') echo ('selected'); ?>>2015</option>
                        <option value='2014'<?php if (isset($profile->bday_year) && $profile->bday_year == '2014') echo ('selected'); ?>>2014</option>
                        <option value='2013'<?php if (isset($profile->bday_year) && $profile->bday_year == '2013') echo ('selected'); ?>>2013</option>
                        <option value='2012'<?php if (isset($profile->bday_year) && $profile->bday_year == '2012') echo ('selected'); ?>>2012</option>
                        <option value='2011'<?php if (isset($profile->bday_year) && $profile->bday_year == '2011') echo ('selected'); ?>>2011</option>
                        <option value='2010'<?php if (isset($profile->bday_year) && $profile->bday_year == '2010') echo ('selected'); ?>>2010</option>
                        <option value='2009'<?php if (isset($profile->bday_year) && $profile->bday_year == '2009') echo ('selected'); ?>>2009</option>
                        <option value='2008'<?php if (isset($profile->bday_year) && $profile->bday_year == '2008') echo ('selected'); ?>>2008</option>
                        <option value='2007'<?php if (isset($profile->bday_year) && $profile->bday_year == '2007') echo ('selected'); ?>>2007</option>
                        <option value='2006'<?php if (isset($profile->bday_year) && $profile->bday_year == '2006') echo ('selected'); ?>>2006</option>
                        <option value='2005'<?php if (isset($profile->bday_year) && $profile->bday_year == '2005') echo ('selected'); ?>>2005</option>
                        <option value='2004'<?php if (isset($profile->bday_year) && $profile->bday_year == '2004') echo ('selected'); ?>>2004</option>
                        <option value='2003'<?php if (isset($profile->bday_year) && $profile->bday_year == '2003') echo ('selected'); ?>>2003</option>
                        <option value='2002'<?php if (isset($profile->bday_year) && $profile->bday_year == '2002') echo ('selected'); ?>>2002</option>
                        <option value='2001'<?php if (isset($profile->bday_year) && $profile->bday_year == '2001') echo ('selected'); ?>>2001</option>
                        <option value='2000'<?php if (isset($profile->bday_year) && $profile->bday_year == '2000') echo ('selected'); ?>>2000</option>
                        <option value='1999'<?php if (isset($profile->bday_year) && $profile->bday_year == '1999') echo ('selected'); ?>>1999</option>
                        <option value='1998'<?php if (isset($profile->bday_year) && $profile->bday_year == '1998') echo ('selected'); ?>>1998</option>
                        <option value='1997'<?php if (isset($profile->bday_year) && $profile->bday_year == '1997') echo ('selected'); ?>>1997</option>
                        <option value='1996'<?php if (isset($profile->bday_year) && $profile->bday_year == '1996') echo ('selected'); ?>>1996</option>
                        <option value='1995'<?php if (isset($profile->bday_year) && $profile->bday_year == '1995') echo ('selected'); ?>>1995</option>
                        <option value='1994'<?php if (isset($profile->bday_year) && $profile->bday_year == '1994') echo ('selected'); ?>>1994</option>
                        <option value='1993'<?php if (isset($profile->bday_year) && $profile->bday_year == '1993') echo ('selected'); ?>>1993</option>
                        <option value='1992'<?php if (isset($profile->bday_year) && $profile->bday_year == '1992') echo ('selected'); ?>>1992</option>
                        <option value='1991'<?php if (isset($profile->bday_year) && $profile->bday_year == '1991') echo ('selected'); ?>>1991</option>
                        <option value='1990'<?php if (isset($profile->bday_year) && $profile->bday_year == '1990') echo ('selected'); ?>>1990</option>
                        <option value='1989'<?php if (isset($profile->bday_year) && $profile->bday_year == '1989') echo ('selected'); ?>>1989</option>
                        <option value='1988'<?php if (isset($profile->bday_year) && $profile->bday_year == '1988') echo ('selected'); ?>>1988</option>
                        <option value='1987'<?php if (isset($profile->bday_year) && $profile->bday_year == '1987') echo ('selected'); ?>>1987</option>
                        <option value='1986'<?php if (isset($profile->bday_year) && $profile->bday_year == '1986') echo ('selected'); ?>>1986</option>
                        <option value='1985'<?php if (isset($profile->bday_year) && $profile->bday_year == '1985') echo ('selected'); ?>>1985</option>
                        <option value='1984'<?php if (isset($profile->bday_year) && $profile->bday_year == '1984') echo ('selected'); ?>>1984</option>
                        <option value='1983'<?php if (isset($profile->bday_year) && $profile->bday_year == '1983') echo ('selected'); ?>>1983</option>
                        <option value='1982'<?php if (isset($profile->bday_year) && $profile->bday_year == '1982') echo ('selected'); ?>>1982</option>
                        <option value='1981'<?php if (isset($profile->bday_year) && $profile->bday_year == '1981') echo ('selected'); ?>>1981</option>
                        <option value='1980'<?php if (isset($profile->bday_year) && $profile->bday_year == '1980') echo ('selected'); ?>>1980</option>
                        <option value='1979'<?php if (isset($profile->bday_year) && $profile->bday_year == '1979') echo ('selected'); ?>>1979</option>
                        <option value='1978'<?php if (isset($profile->bday_year) && $profile->bday_year == '1978') echo ('selected'); ?>>1978</option>
                        <option value='1977'<?php if (isset($profile->bday_year) && $profile->bday_year == '1977') echo ('selected'); ?>>1977</option>
                        <option value='1976'<?php if (isset($profile->bday_year) && $profile->bday_year == '1976') echo ('selected'); ?>>1976</option>
                        <option value='1975'<?php if (isset($profile->bday_year) && $profile->bday_year == '1975') echo ('selected'); ?>>1975</option>
                        <option value='1974'<?php if (isset($profile->bday_year) && $profile->bday_year == '1974') echo ('selected'); ?>>1974</option>
                        <option value='1973'<?php if (isset($profile->bday_year) && $profile->bday_year == '1973') echo ('selected'); ?>>1973</option>
                        <option value='1972'<?php if (isset($profile->bday_year) && $profile->bday_year == '1972') echo ('selected'); ?>>1972</option>
                        <option value='1971'<?php if (isset($profile->bday_year) && $profile->bday_year == '1971') echo ('selected'); ?>>1971</option>
                        <option value='1970'<?php if (isset($profile->bday_year) && $profile->bday_year == '1970') echo ('selected'); ?>>1970</option>
                        <option value='1969'<?php if (isset($profile->bday_year) && $profile->bday_year == '1969') echo ('selected'); ?>>1969</option>
                        <option value='1968'<?php if (isset($profile->bday_year) && $profile->bday_year == '1968') echo ('selected'); ?>>1968</option>
                        <option value='1967'<?php if (isset($profile->bday_year) && $profile->bday_year == '1967') echo ('selected'); ?>>1967</option>
                        <option value='1966'<?php if (isset($profile->bday_year) && $profile->bday_year == '1966') echo ('selected'); ?>>1966</option>
                        <option value='1965'<?php if (isset($profile->bday_year) && $profile->bday_year == '1965') echo ('selected'); ?>>1965</option>
                        <option value='1964'<?php if (isset($profile->bday_year) && $profile->bday_year == '1964') echo ('selected'); ?>>1964</option>
                        <option value='1939'<?php if (isset($profile->bday_year) && $profile->bday_year == '1963') echo ('selected'); ?>>1963</option>
                        <option value='1962'<?php if (isset($profile->bday_year) && $profile->bday_year == '1962') echo ('selected'); ?>>1962</option>
                        <option value='1961'<?php if (isset($profile->bday_year) && $profile->bday_year == '1961') echo ('selected'); ?>>1961</option>
                        <option value='1960'<?php if (isset($profile->bday_year) && $profile->bday_year == '1960') echo ('selected'); ?>>1960</option>
                        <option value='1959'<?php if (isset($profile->bday_year) && $profile->bday_year == '1959') echo ('selected'); ?>>1959</option>
                        <option value='1958'<?php if (isset($profile->bday_year) && $profile->bday_year == '1958') echo ('selected'); ?>>1958</option>
                        <option value='1957'<?php if (isset($profile->bday_year) && $profile->bday_year == '1957') echo ('selected'); ?>>1957</option>
                        <option value='1956'<?php if (isset($profile->bday_year) && $profile->bday_year == '1956') echo ('selected'); ?>>1956</option>
                        <option value='1955'<?php if (isset($profile->bday_year) && $profile->bday_year == '1955') echo ('selected'); ?>>1955</option>
                        <option value='1954'<?php if (isset($profile->bday_year) && $profile->bday_year == '1954') echo ('selected'); ?>>1954</option>
                        <option value='1953'<?php if (isset($profile->bday_year) && $profile->bday_year == '1953') echo ('selected'); ?>>1953</option>
                        <option value='1952'<?php if (isset($profile->bday_year) && $profile->bday_year == '1952') echo ('selected'); ?>>1952</option>
                        <option value='1951'<?php if (isset($profile->bday_year) && $profile->bday_year == '1951') echo ('selected'); ?>>1951</option>
                        <option value='1950'<?php if (isset($profile->bday_year) && $profile->bday_year == '1950') echo ('selected'); ?>>1950</option>
                    </select>
                </div> 
            </div>

            <div class='form-row'>
                <div class='input-container'>
                    <i class='fa-solid fa-venus-mars' title='Gender'></i>
                    <select class='input-field' name='gender'>
                        <option value=''>What is your gender identity?</option>
                        <option value='m'<?php if (isset($profile->gender) && $profile->gender == 'm') echo ('selected'); ?>>Male</option>
                        <option value='f'<?php if (isset($profile->gender) && $profile->gender == 'f') echo ('selected');?>>Female</option>
                        <option value='t'<?php if (isset($profile->gender) && $profile->gender == 't') echo ('selected'); ?>>Transgender</option>
                        <option value='p'<?php if (isset($profile->gender) && $profile->gender == 'p') echo ('selected'); ?>>Prefer Not to Say</option>
                    </select>
                </div>
            </div>

            <div class='form-row'>
                <div class='input-container'>
                    <i class='fa-solid fa-briefcase' title='Occupation'></i>

                    <?php $attributes = [
                            'name'          => 'occupation',
                            'type'          => 'text',
                            'class'         => 'input-field',
                            'id'            => 'occupation',
                            'placeholder'   => 'What is your occupation?',
                            'rows'          => '2',
                    ];?>
                    <?= form_input($attributes, !empty($profile->occupation)?$profile->occupation:''); ?>
                </div>
            </div>

            <div class='form-row'>
                <div class='input-container'>
                    <i class='fa-solid fa-location-dot' title='Hometown'></i>

                      <?php $attributes = [
                            'name'          => 'hometown',
                            'type'          => 'text',
                            'class'         => 'input-field',
                            'id'            => 'hometown',
                            'placeholder'   => 'What is your hometown?',
                    ];?>
                    <?= form_input($attributes, !empty($profile->hometown)?$profile->hometown:''); ?>
                </div>
            </div>

            <div class='form-row'>
                <div class='input-container'>
                    <i class="fa-solid fa-earth-americas" title='Country'></i></i>
                    <select class='input-field' name='country'>
                        <option value=''>What country are you in?</option>
                        <option value='United States of America'<?php if (isset($profile->country) && $profile->country == 'United States of America') echo ('selected'); ?>>United States of America</option>
                        <option value='Afganistan'>Afghanistan</option>
                        <option value='Albania'>Albania</option>
                        <option value='Algeria'>Algeria</option>
                        <option value='American Samoa'>American Samoa</option>
                        <option value='Andorra'>Andorra</option>
                        <option value='Angola'>Angola</option>
                        <option value='Anguilla'>Anguilla</option>
                        <option value='Antigua & Barbuda'>Antigua & Barbuda</option>
                        <option value='Argentina'>Argentina</option>
                        <option value='Armenia'>Armenia</option>
                        <option value='Aruba'>Aruba</option>
                        <option value='Australia'>Australia</option>
                        <option value='Austria'>Austria</option>
                        <option value='Azerbaijan'>Azerbaijan</option>
                        <option value='Bahamas'>Bahamas</option>
                        <option value='Bahrain'>Bahrain</option>
                        <option value='Bangladesh'>Bangladesh</option>
                        <option value='Barbados'>Barbados</option>
                        <option value='Belarus'>Belarus</option>
                        <option value='Belgium'>Belgium</option>
                        <option value='Belize'>Belize</option>
                        <option value='Benin'>Benin</option>
                        <option value='Bermuda'>Bermuda</option>
                        <option value='Bhutan'>Bhutan</option>
                        <option value='Bolivia'>Bolivia</option>
                        <option value='Bonaire'>Bonaire</option>
                        <option value='Bosnia & Herzegovina'>Bosnia & Herzegovina</option>
                        <option value='Botswana'>Botswana</option>
                        <option value='Brazil'>Brazil</option>
                        <option value='British Indian Ocean Ter'>British Indian Ocean Ter</option>
                        <option value='Brunei'>Brunei</option>
                        <option value='Bulgaria'>Bulgaria</option>
                        <option value='Burkina Faso'>Burkina Faso</option>
                        <option value='Burundi'>Burundi</option>
                        <option value='Cambodia'>Cambodia</option>
                        <option value='Cameroon'>Cameroon</option>
                        <option value='Canada'>Canada</option>
                        <option value='Canary Islands'>Canary Islands</option>
                        <option value='Cape Verde'>Cape Verde</option>
                        <option value='Cayman Islands'>Cayman Islands</option>
                        <option value='Central African Republic'>Central African Republic</option>
                        <option value='Chad'>Chad</option>
                        <option value='Channel Islands'>Channel Islands</option>
                        <option value='Chile'>Chile</option>
                        <option value='China'>China</option>
                        <option value='Christmas Island'>Christmas Island</option>
                        <option value='Cocos Island'>Cocos Island</option>
                        <option value='Colombia'>Colombia</option>
                        <option value='Comoros'>Comoros</option>
                        <option value='Congo'>Congo</option>
                        <option value='Cook Islands'>Cook Islands</option>
                        <option value='Costa Rica'>Costa Rica</option>
                        <option value='Cote DIvoire'>Cote DIvoire</option>
                        <option value='Croatia'>Croatia</option>
                        <option value='Cuba'>Cuba</option>
                        <option value='Curaco'>Curacao</option>
                        <option value='Cyprus'>Cyprus</option>
                        <option value='Czech Republic'>Czech Republic</option>
                        <option value='Denmark'>Denmark</option>
                        <option value='Djibouti'>Djibouti</option>
                        <option value='Dominica'>Dominica</option>
                        <option value='Dominican Republic'>Dominican Republic</option>
                        <option value='East Timor'>East Timor</option>
                        <option value='Ecuador'>Ecuador</option>
                        <option value='Egypt'>Egypt</option>
                        <option value='El Salvador'>El Salvador</option>
                        <option value='Equatorial Guinea'>Equatorial Guinea</option>
                        <option value='Eritrea'>Eritrea</option>
                        <option value='Estonia'>Estonia</option>
                        <option value='Ethiopia'>Ethiopia</option>
                        <option value='Falkland Islands'>Falkland Islands</option>
                        <option value='Faroe Islands'>Faroe Islands</option>
                        <option value='Fiji'>Fiji</option>
                        <option value='Finland'>Finland</option>
                        <option value='France'>France</option>
                        <option value='French Guiana'>French Guiana</option>
                        <option value='French Polynesia'>French Polynesia</option>
                        <option value='French Southern Ter'>French Southern Ter</option>
                        <option value='Gabon'>Gabon</option>
                        <option value='Gambia'>Gambia</option>
                        <option value='Georgia'>Georgia</option>
                        <option value='Germany'>Germany</option>
                        <option value='Ghana'>Ghana</option>
                        <option value='Gibraltar'>Gibraltar</option>
                        <option value='Great Britain'>Great Britain</option>
                        <option value='Greece'>Greece</option>
                        <option value='Greenland'>Greenland</option>
                        <option value='Grenada'>Grenada</option>
                        <option value='Guadeloupe'>Guadeloupe</option>
                        <option value='Guam'>Guam</option>
                        <option value='Guatemala'>Guatemala</option>
                        <option value='Guinea'>Guinea</option>
                        <option value='Guyana'>Guyana</option>
                        <option value='Haiti'>Haiti</option>
                        <option value='Hawaii'>Hawaii</option>
                        <option value='Honduras'>Honduras</option>
                        <option value='Hong Kong'>Hong Kong</option>
                        <option value='Hungary'>Hungary</option>
                        <option value='Iceland'>Iceland</option>
                        <option value='Indonesia'>Indonesia</option>
                        <option value='India'>India</option>
                        <option value='Iran'>Iran</option>
                        <option value='Iraq'>Iraq</option>
                        <option value='Ireland'>Ireland</option>
                        <option value='Isle of Man'>Isle of Man</option>
                        <option value='Israel'>Israel</option>
                        <option value='Italy'>Italy</option>
                        <option value='Jamaica'>Jamaica</option>
                        <option value='Japan'>Japan</option>
                        <option value='Jordan'>Jordan</option>
                        <option value='Kazakhstan'>Kazakhstan</option>
                        <option value='Kenya'>Kenya</option>
                        <option value='Kiribati'>Kiribati</option>
                        <option value='Korea North'>Korea North</option>
                        <option value='Korea Sout'>Korea South</option>
                        <option value='Kuwait'>Kuwait</option>
                        <option value='Kyrgyzstan'>Kyrgyzstan</option>
                        <option value='Laos'>Laos</option>
                        <option value='Latvia'>Latvia</option>
                        <option value='Lebanon'>Lebanon</option>
                        <option value='Lesotho'>Lesotho</option>
                        <option value='Liberia'>Liberia</option>
                        <option value='Libya'>Libya</option>
                        <option value='Liechtenstein'>Liechtenstein</option>
                        <option value='Lithuania'>Lithuania</option>
                        <option value='Luxembourg'>Luxembourg</option>
                        <option value='Macau'>Macau</option>
                        <option value='Macedonia'>Macedonia</option>
                        <option value='Madagascar'>Madagascar</option>
                        <option value='Malaysia'>Malaysia</option>
                        <option value='Malawi'>Malawi</option>
                        <option value='Maldives'>Maldives</option>
                        <option value='Mali'>Mali</option>
                        <option value='Malta'>Malta</option>
                        <option value='Marshall Islands'>Marshall Islands</option>
                        <option value='Martinique'>Martinique</option>
                        <option value='Mauritania'>Mauritania</option>
                        <option value='Mauritius'>Mauritius</option>
                        <option value='Mayotte'>Mayotte</option>
                        <option value='Mexico'>Mexico</option>
                        <option value='Midway Islands'>Midway Islands</option>
                        <option value='Moldova'>Moldova</option>
                        <option value='Monaco'>Monaco</option>
                        <option value='Mongolia'>Mongolia</option>
                        <option value='Montserrat'>Montserrat</option>
                        <option value='Morocco'>Morocco</option>
                        <option value='Mozambique'>Mozambique</option>
                        <option value='Myanmar'>Myanmar</option>
                        <option value='Nambia'>Nambia</option>
                        <option value='Nauru'>Nauru</option>
                        <option value='Nepal'>Nepal</option>
                        <option value='Netherland Antilles'>Netherland Antilles</option>
                        <option value='Netherlands'>Netherlands (Holland, Europe)</option>
                        <option value='Nevis'>Nevis</option>
                        <option value='New Caledonia'>New Caledonia</option>
                        <option value='New Zealand'>New Zealand</option>
                        <option value='Nicaragua'>Nicaragua</option>
                        <option value='Niger'>Niger</option>
                        <option value='Nigeria'>Nigeria</option>
                        <option value='Niue'>Niue</option>
                        <option value='Norfolk Island'>Norfolk Island</option>
                        <option value='Norway'>Norway</option>
                        <option value='Oman'>Oman</option>
                        <option value='Pakistan'>Pakistan</option>
                        <option value='Palau Island'>Palau Island</option>
                        <option value='Palestine'>Palestine</option>
                        <option value='Panama'>Panama</option>
                        <option value='Papua New Guinea'>Papua New Guinea</option>
                        <option value='Paraguay'>Paraguay</option>
                        <option value='Peru'>Peru</option>
                        <option value='Phillipines'>Philippines</option>
                        <option value='Pitcairn Island'>Pitcairn Island</option>
                        <option value='Poland'>Poland</option>
                        <option value='Portugal'>Portugal</option>
                        <option value='Puerto Rico'>Puerto Rico</option>
                        <option value='Qatar'>Qatar</option>
                        <option value='Republic of Montenegro'>Republic of Montenegro</option>
                        <option value='Republic of Serbia'>Republic of Serbia</option>
                        <option value='Reunion'>Reunion</option>
                        <option value='Romania'>Romania</option>
                        <option value='Russia'>Russia</option>
                        <option value='Rwanda'>Rwanda</option>
                        <option value='St Barthelemy'>St Barthelemy</option>
                        <option value='St Eustatius'>St Eustatius</option>
                        <option value='St Helena'>St Helena</option>
                        <option value='St Kitts-Nevis'>St Kitts-Nevis</option>
                        <option value='St Lucia'>St Lucia</option>
                        <option value='St Maarten'>St Maarten</option>
                        <option value='St Pierre & Miquelon'>St Pierre & Miquelon</option>
                        <option value='St Vincent & Grenadines'>St Vincent & Grenadines</option>
                        <option value='Saipan'>Saipan</option>
                        <option value='Samoa'>Samoa</option>
                        <option value='Samoa American'>Samoa American</option>
                        <option value='San Marino'>San Marino</option>
                        <option value='Sao Tome & Principe'>Sao Tome & Principe</option>
                        <option value='Saudi Arabia'>Saudi Arabia</option>
                        <option value='Senegal'>Senegal</option>
                        <option value='Seychelles'>Seychelles</option>
                        <option value='Sierra Leone'>Sierra Leone</option>
                        <option value='Singapore'>Singapore</option>
                        <option value='Slovakia'>Slovakia</option>
                        <option value='Slovenia'>Slovenia</option>
                        <option value='Solomon Islands'>Solomon Islands</option>
                        <option value='Somalia'>Somalia</option>
                        <option value='South Africa'>South Africa</option>
                        <option value='Spain'>Spain</option>
                        <option value='Sri Lanka'>Sri Lanka</option>
                        <option value='Sudan'>Sudan</option>
                        <option value='Suriname'>Suriname</option>
                        <option value='Swaziland'>Swaziland</option>
                        <option value='Sweden'>Sweden</option>
                        <option value='Switzerland'>Switzerland</option>
                        <option value='Syria'>Syria</option>
                        <option value='Tahiti'>Tahiti</option>
                        <option value='Taiwan'>Taiwan</option>
                        <option value='Tajikistan'>Tajikistan</option>
                        <option value='Tanzania'>Tanzania</option>
                        <option value='Thailand'>Thailand</option>
                        <option value='Togo'>Togo</option>
                        <option value='Tokelau'>Tokelau</option>
                        <option value='Tonga'>Tonga</option>
                        <option value='Trinidad & Tobago'>Trinidad & Tobago</option>
                        <option value='Tunisia'>Tunisia</option>
                        <option value='Turkey'>Turkey</option>
                        <option value='Turkmenistan'>Turkmenistan</option>
                        <option value='Turks & Caicos Is'>Turks & Caicos Is</option>
                        <option value='Tuvalu'>Tuvalu</option>
                        <option value='Uganda'>Uganda</option>
                        <option value='United Kingdom'>United Kingdom</option>
                        <option value='Ukraine'>Ukraine</option>
                        <option value='United Arab Erimates'>United Arab Emirates</option>
                        <option value='Uraguay'>Uruguay</option>
                        <option value='Uzbekistan'>Uzbekistan</option>
                        <option value='Vanuatu'>Vanuatu</option>
                        <option value='Vatican City State'>Vatican City State</option>
                        <option value='Venezuela'>Venezuela</option>
                        <option value='Vietnam'>Vietnam</option>
                        <option value='Virgin Islands (Brit)'>Virgin Islands (Brit)</option>
                        <option value='Virgin Islands (USA)'>Virgin Islands (USA)</option>
                        <option value='Wake Island'>Wake Island</option>
                        <option value='Wallis & Futana Is'>Wallis & Futana Is</option>
                        <option value='Yemen'>Yemen</option>
                        <option value='Zaire'>Zaire</option>
                        <option value='Zambia'>Zambia</option>
                        <option value='Zimbabwe'>Zimbabwe</option>
                    </select>
                </div>
            </div>

            <div class='form-row'>
                <div class='input-container'>
                    <i class="fa-solid fa-shapes"></i>
                    <select class='input-field' name='fav_shape' title='Favorite Shape'>
                        <option value=''>What's your favorite shape?</option>
                        <option value='triangle'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'triangle') echo ('selected'); ?>>Triangle</option>
                        <option value='circle'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'circle') echo ('selected'); ?>>Circle</option>
                        <option value='square'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'square') echo ('selected'); ?>>Square</option>
                        <option value='rectangle'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'rectangle') echo ('selected'); ?>>Rectangle</option>
                        <option value='parallelogram'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'parallelogram') echo ('selected'); ?>>Parallelogram</option>
                        <option value='rhombus'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'rhombus') echo ('selected'); ?>>Rhombus</option>
                        <option value='pentagon'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'pentagon') echo ('selected'); ?>>Pentagon</option>
                        <option value='hexagon'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'hexagon') echo ('selected'); ?>>Hexagon</option>
                        <option value='octagon'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'octagon') echo ('selected'); ?>>Octagon</option>
                        <option value='star'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'star') echo ('selected'); ?>>Star</option>
                        <option value='heart'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'heart') echo ('selected'); ?>>Heart</option>
                        <option value='other'<?php if (isset($profile->fav_shape) && $profile->fav_shape == 'other') echo ('selected'); ?>>Other</option>
                    </select>
                </div>

                <div class='input-container'>
                    <i class="fa-solid fa-brush"></i>
                    <select class='input-field' name='fav_color' title='Favorite Color'>
                        <option value=''>What's your favorite color?</option>
                        <option value='red'<?php if (isset($profile->fav_color) && $profile->fav_color == 'red') echo ('selected'); ?>>Red</option>
                        <option value='orange'<?php if (isset($profile->fav_color) && $profile->fav_color == 'orange') echo ('selected'); ?>>Orange</option>
                        <option value='yellow'<?php if (isset($profile->fav_color) && $profile->fav_color == 'yellow') echo ('selected'); ?>>Yellow</option>
                        <option value='green'<?php if (isset($profile->fav_color) && $profile->fav_color == 'green') echo ('selected'); ?>>Green</option>
                        <option value='blue'<?php if (isset($profile->fav_color) && $profile->fav_color == 'blue') echo ('selected'); ?>>Blue</option>
                        <option value='purple'<?php if (isset($profile->fav_color) && $profile->fav_color == 'purple') echo ('selected'); ?>>Purple</option>
                        <option value='pink'<?php if (isset($profile->fav_color) && $profile->fav_color == 'pink') echo ('selected'); ?>>Pink</option>
                        <option value='black'<?php if (isset($profile->fav_color) && $profile->fav_color == 'black') echo ('selected'); ?>>Black</option>
                        <option value='other'<?php if (isset($profile->fav_color) && $profile->fav_color == 'other') echo ('selected'); ?>>Other</option>
                    </select>
                </div>
            </div>
        </div>

        <div class='form-footer'>

            <?php $attributes = [
                'name'      => 'editSubmit',
                'value'     => 'Update',
                'class'     => 'submit-btn',
            ]; ?>
            <?= form_submit($attributes); ?>
            
        </div>
    <?= form_close(); ?>
</div>