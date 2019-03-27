=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
LICENSE
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
CART BOXX - Version 0.4 Alpha
Copyright 2018 by Code Boxx

عدل الملف الموجود داخل 
core/config.php
ليتضمن معلومات قاعدة البيانات
ايضا عدل الملف 
.htacess 


للمزيد من الشرح الرجاء الاطلاع على الفيديو على قناتنا في اليوتيوب
https://youtu.be/Vjt9RAAs4bc

رابط صفحة الادارة
 http://اسم موقعك/jalamari
بيانات الدخول الافتراضية
jalamari@uccs.edu
125600bczz

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.



=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
INSTALLATION ???????
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
1) Create new database and import cart_boxx.sql
?? ?????? ????? ???????? ?? ?????? ????? ???????? ??????? ????? 
2) Update database settings and URL_ROOT in core/config.php
??? ??????? ????? ??????? ???? core/config.php
3) DONE!


Admin panel is by default deployed at http://yoursite.com/jalamari





=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
DOCUMENTATION
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
Please visit https://code-boxx.com/cart-boxx for the documentation.



=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
WHAT'S NEW IN 0.4 ALPHA
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
- A lot of visual and CSS upgrades.
- Fixed the dumb infinite URL. I.E. http://site.com/products/one/two/three/four
  now shows a 404... Unless you allow it.
- API structure slightly changed - Admin requests are now at /API/admin/module.
- Admin pages are now AJAX driven.
- Search functions for users, products, and categories.
- Able to update orders status.
- Change in theme structure. Individual files instead of throwing everything 
  at index.php
- Small additions and fixes everywhere to API and libraries.



=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
TO DO LIST / WHAT'S MISSING / WISH LIST
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
- Product attributes (color, size, options)
- Product reviews
- Product tags
- Stock management
- Delivery methods (shipping, self-collect, digital download)
- Better pagination for large datasets
- Better orders management
- Discount Coupons
- Paypal, Stripe
- Generate invoice
- Reports in admin
- Theme management & customization
- User custom pages
- A proper installer
- Front end allow users to view their orders
- Plugins & developer's kit?!



=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
CREDITS
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
Cart Boxx is made possible only with the help of other open source.

jQuery - https://jquery.com/
jQuery UI - https://jqueryui.com/
Bootstrap - https://getbootstrap.com/
Font Awesome - https://fontawesome.com/
TinyMCE - https://www.tinymce.com/
Bootstrap Notify - http://bootstrap-notify.remabledesigns.com/
ELFinder - https://studio-42.github.io/elFinder
