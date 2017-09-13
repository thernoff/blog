//Отслеживание изображения, которое рассматривается в данный момент
var curImage = null;

function id(id){
    return document.getElementById(id);
}
//Определение позиции X (горизонтальной слева) элемента
function pageX(elem){
    return elem.offsetParent ?
        //Если не дошли до самого верха, добавление текущего смещения и продолжение движения вверх
        elem.offsetLeft + pageX(elem.offsetParent) :
        //В противном случае получение текущего смещения
        elem.offsetLeft;
}
//Определение позиции Y (вертикальной сверху) элемента
function pageY(elem){
    //Проверка на достижения корневого элемента
    return elem.offsetParent ?
        //Если не дошли до самого верха, добавление текущего смещения и продолжение движения вверх
        elem.offsetTop + pageY(elem.offsetParent) :
        //В противном случае получение текущего смещения
        elem.offsetTop;
}
//Получение высоты веб-страницы
function pageHeight(){
    return document.body.scrollHeight;
}
//Получение ширины веб-страницы
function pageWidth(){
    return document.body.scrollWidth;
}

//Получение текущей высоты элемента (с использованием вычисляемого CSS-свойства)
function getHeight(elem){
    var computedStyle = getComputedStyle(elem);
    return parseInt(computedStyle.height);
}

//Получение текущей ширины элемента (с использованием вычисляемого CSS-свойства)
function getWidth(elem){
    var computedStyle = getComputedStyle(elem);
    return parseInt(computedStyle.width);
}

//Функция для определения величины горизонтальной прокрутки браузера
function scrollX(){
    //Сокращение на случай использования IE6 в строгом (strict) режиме
    var de = document.documentElement;
    
    //Использование свойства браузера pageXOffset, если оно доступно
    return self.pageXOffset ||
        //в противном случае попытка получить прокрутку слева из корневого узла
        (de && de.scrollLeft) ||
        //и наконец, попытка получить прокрутку слева из элемента body
        document.body.scrollLeft;
}

//Функция для определения величины вертикальной прокрутки браузера
function scrollY(){
    //Сокращение на случай использования IE6 в строгом (strict) режиме
    var de = document.documentElement;
    
    //Использование свойства браузера pageYOffset, если оно доступно
    return self.pageYOffset ||
        //в противном случае попытка получить прокрутку сверху из корневого узла
        (de && de.scrollTop) ||
        //и наконец, попытка получить прокрутку сверху из элемента body
        document.body.scrollTop;
}

//Определение высоты области просмотра
function windowHeight(){
    //Сокращение на случай использования IE6 в строгом (strict) режиме
    var de = document.documentElement;
    
    //Использование свойства innerHeight браузера, если оно доступно
    return self.innerHeight ||
        //в противном случае попытка получить высоту из корневого узла
        (de && de.clientHeight) ||
        //и наконец, попытка получить высоту из элемента body
        document.body.clientHeight;
}

//Определение ширины области просмотра
function windowWidth(){
    //Сокращение на случай использования IE6 в строгом (strict) режиме
    var de = document.documentElement;
    
    //Использование свойства innerWidht браузера, если оно доступно
    return self.innerWidth ||
        //в противном случае попытка получить ширину из корневого узла
        (de && de.clientWidth) ||
        //и наконец, попытка получить ширину из элемента body
        document.body.clientWidth;
}

//Установка горизонтальной позиции элемента
function setX(elem, pos){
    console.log(pos);
    var pos = parseInt(pos);
    elem.style.left = pos + "px";
    console.log("left: " + pos);
    console.log(elem);
}

//Установка вертикальной позиции элемента
function setY(elem, pos){
    var pos = parseInt(pos);
    elem.style.top = pos + "px";
    console.log("top: " + pos);
    console.log(elem);
}
//Функция для обнаружения первого дочернего элемента по отношению к переданному
function first(elem){
    elem = elem.firstChild;
    return elem && elem.nodeType != 1 ? next(elem) : elem;
}
//Обнаружение предыдущего сестринского элемента по отношению к 
// переданному элементу
function prev(elem){
    do {
        elem = elem.previousSibling;
    } while (elem && elem.nodeType != 1);
    return elem;
}

//Обнаружение следующего сестринского элемента по отношению к 
// переданному элементу
function next(elem){
    do {
        elem = elem.nextSibling;
    } while (elem && elem.nodeType != 1);
    return elem;
}

//Функция получения для элемента реального вычисленного значения CSS-свойства
function getStyle(elem, name){
    //Если свойство присутствует в style[], значит, оно было недавно установлено и является текущим
    if (elem.style[name]){
        return elem.style[name];
    }
    //В противном случае воспользоваться IE-методом
    else if (elem.currentStyle){
        return elem.currentStyle[name];
    }
    //или W3C-методом, если он существует
    else if (document.defaultView && document.defaultView.getComputedStyle){
        //вместо textAlign используем традиционное правило
        //написание стиля - "text-align"
        name = name.replace(/([A-Z])/g, "-$1");
        name = name.toLowerCase();
        //Получение объекта style и получение значения свойства (если оно существует)
        var s = document.defaultView.getComputedStyle(elem, "");
        return s && s.getPropertyValue(name);
    }else{
        return null;
    }
}

//Функция для скрытия элемента с использованием свойства display
function hide(elem){
    var curDisplay = getStyle(elem, "display");
    //Запоминание состояния свойства display на будующее
    if (curDisplay != "none"){
        elem.$oldDisplay = curDisplay;
    }
    //Установка display в none (скрытие элемента)
    elem.style.display = "none";
}

//Функция вывода элемента (с использованием свойства display)
function show(elem){
    elem.style.display = elem.$oldDisplay || "";
}

//Скрытие перекрытия текущей галереи
function hideOverlay(){
    //Перезапуск значения текущего изображения
    curImage = null;
    //и скрытия перекрытия и галереи
    var overlay = id("overlay");
    var gallery = id("gallery");
    hide(id("overlay"));
    hide(id("gallery"));
}

//Проявление перекрытия
function showOverlay(){
    //Обнаружение перекрытия
    var over = id("overlay");
    //Установка его размеров по высоте и ширине текущей страницы (что пригодится в случае прокрутки)
    over.style.height = pageHeight() + "px";
    over.style.width = pageWidth() + "px";
    over.style.display = "block";
    //и проявление
    //fadeIn(over, 50, 10);
}

//Вывод выбранного изображения внутри галереи
function showImage(cur){
    
    //Запоминание текущего изображения
    curImage = cur;
    //Обнаружение изображения в галерее
    var img = id("gallery_image");
    
    if (next(cur)){
        img.onclick = nextImage;
    }else{
        img.onclick = function(){
            return false;
        }
    }
    
    //Удаление изображения, если таковое уже показывалось
    if (first(img)){
        img.removeChild(first(img));
    }
    //и добавление вместо него нового изображения
    var a = first(cur).cloneNode(true);
    var a_img = first(a);
    a_img.src = a.href;
    img.appendChild(a);
    //Установка подписи к изображению в качестве содержимого
    //аргумента alt обычного изображения
    //id("gallery_title").innerHTML = cur.firstChild.firstChild.alt;
    //Обнаружение основной галереи
    var gallery = id("gallery");
    //Установка правильного класса (чтобы был получен правильный размер)
    gallery.className = cur.className;
    //и проявление
    gallery.style.display = "block";
    //fadeIn(gallery, 100, 10);
    
    //Обеспечение позиционирования галереи в правильном месте экрана
    adjust();
    
    //Скрытие ссылки Next, если мы дошли до конца галереи
    if (!next(cur)){
        hide(id("gallery_next"));
    } else {
        show(id("gallery_next"));
    };
    
    //Скрытие ссылки Prev, если мы дошли до конца галереи
    if (!prev(cur)){
        hide(id("gallery_prev"));
    } else {
        show(id("gallery_prev"));
    }
}

//Повторное позиционирование галереи по центру видимой части страницы даже после ее прокрутки
function adjust(){
    //Обнаружение галереи
    var obj = id("gallery");
    //Определение существования галереи
    if (!obj){
        return;
    }
    //Опеределение ее текущих высоты и ширины
    var w = getWidth(obj);
    var h = getHeight(obj);
    
    //Вертикальное позиционирование контейнера посредине окна
    var t = scrollY() + (windowHeight()/2) - (h/2);
    
    //Но не выше верхней части страницы
    if (t<0){
        t = 0;
    }
    //Горизонтальное позиционирование контейнера посредине окна
    var l = scrollX() + (windowWidth()/2) - (w/2);
    
    //Но не левее, чем левый край страницы
    if (l<0){
        l = 0;
    }
    
    //Установка выверенной позиции элемента
    setY(obj, t);
    setX(obj, l);
}

//Обнаружение и вывод предыдущего изображения
function prevImage(){
    showImage(prev(curImage));
    return false;
}

//Обнаружение и вывод следующего изображения
function nextImage(){
    showImage(next(curImage));
    return false;
}

//Ожидание окончания загрузки страницы перед тем, как вносить изменения или перемещаться по DOM-структуре
window.onload = function(){
    
    //Создание контейнера для всей галереи
    var gallery = document.createElement("div");
    gallery.id = "gallery";
    
    //Добавление в него всех управляющих контейнеров div
    gallery.innerHTML = '<div id="gallery_image"></div>' +
        '<div id="gallery_prev"><a href="">&laquo; Prev</a></div>' +
        '<div id="gallery_next"><a href="">Next &raquo;</a></div>' +
        '<div id="gallery_title"></div>';
    
    //Добавление элемента gallery в DOM-структуру
    document.body.appendChild(gallery);
    
    //Поддержка обработки каждой ссылки Next и Prev
    id("gallery_next").onclick = nextImage;
    id("gallery_prev").onclick = prevImage;
    
    //Обнаружение всех галерей на странице
    var g = document.querySelectorAll("ul.gallery");
    
    //Последовательный перебор всех галерей
    for (var i=0; i < g.length; i++){
        //и обнаружение всех ссылок на демонстрируемые изображения
        var links = g[i].getElementsByTagName("a");
        //Последовательный перебор ссылок на изображения
        for (var j=0; j < links.length; j++){
            //По щелчку на ссылке вместо перехода к изображению должна выводиться галерея изображений
            links[j].onclick = function(){
                //Вывод серого фона
                showOverlay();
                //Вывод изображения в галерее
                showImage(this.parentNode);
                //Блокировка обычных действий браузера по переходу на изображение
                return false;
                
            };
        }
        //Добавление к галерее средств перехода в режиме демонстрации изображений
        //addSlideShow(g[i]);
    }
    
    //Создание прозрачного серого покрытия
    var overlay = document.createElement('div');
    overlay.id = "overlay";
    //Скрытие фона и галереи по щелчку на сером фоне
    overlay.onclick = hideOverlay;
    
    //Включение перекрытия в DOM-структуру
    document.body.appendChild(overlay);
    
    //Корректировка позиции галереи после каждой прокрутки страницы или изменения размеров окна браузера
    window.onresize = document.onscroll = adjust;
}