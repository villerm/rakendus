<?php
    /*
    Pakun välja, et klassi konstruktorile tuleks saata parameetrina veel vähemalt üks parameeter - pildifaili maksimaalne lubatud suurus. See võimaldab ka pildi suuruse kontrollimist klassis.
	Kes soovib, võib saata ka kolmanda parameetri, mille väärtuseks näiteks massiiv lubatud pilditüüpidega (image/jpeg jt). Siis saaks kasutada meie esimesel tunnil tehtud pilditüübi kontrolli näidet. Aga võime leppida ka praeguse näitega - ainult jpeg ja png ning muuta ei saa.
	Klassi konstruktorist kutsutakse välja ka klassi funktsioon, mis kontrollib, kas on pilt, lubatud suurusega, lubatud tööpi, et kas tohib üles laadida. Funktsioon võiks anda klassi muutujale error väärtuse. Siis saame edasi tegutseda vastavalt error muutuja väärtusele. See error peaks olema ka public muutuja, et klassi kasutav põhiprogramm saaks seda küsida ning vastavalt tegutseda.
    */
    class valmis {
    
}