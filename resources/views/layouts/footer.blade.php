<footer>
  <div class="footer-wrap ">
    <div class="footer flex flex-spc-ard">
      <div class="footer-icon flex flex-jst-c flex-dr-col">
        <a href="{{ URL('/') }}">
          <img src="{{ asset('assets/img/main/logo.jpg') }}" alt="" style="width:100px">
        </a>
         <div class="">
          <span>Company name</span>
        </div>
      </div>  
      <div class="footer-categories flex flex-jst-c flex-dr-col">
        <p>Categories</p>
        <ul>
          @foreach ($animals_arr as $key => $values)
          <li>
            <a href={{ '/' . $key }}><?= Str::ucfirst($key)?></a>
          </li>
          @endforeach ()
        </ul>
      </div>
      <div class="footer-contacts flex flex-jst-c flex-dr-col">
        <p>Contacts</p>
        <ul>
          <li>
            <i>Email: example@gmail.com</i>
          </li>
          <li>
            <i>Phone: +380971111111</i>
          </li>
          <li>
            <i>Phone: +380631111111</i>
          </li>
        </ul>
      </div>
      <div class="footer-feedback flex flex-align-c">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2541.782262505575!2d30.560863415883016!3d50.426528296968996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2sua!4v1660721849984!5m2!1sru!2sua" width="300" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
    
  </div>
</footer>