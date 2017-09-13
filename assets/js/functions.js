(function(){
    function translit(){
    // Символ, на который будут заменяться все спецсимволы
    var space = '-'; 
    // Берем значение из нужного поля и переводим в нижний регистр
    var text = document.getElementById('title').value.toLowerCase();

    // Массив для транслитерации
    var transl = {
    'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh', 
    'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
    'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
    'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': space, 'ы': 'y', 'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya',
    ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
    '#': space, '$': space, '%': space, '^': space, '&': space, '*': space, 
    '(': space, ')': space,'-': space, '\=': space, '+': space, '[': space, 
    ']': space, '\\': space, '|': space, '/': space,'.': space, ',': space,
    '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
    '?': space, '<': space, '>': space, '№':space
    }

    var result = '';
    var curent_sim = '';

    for(i=0; i < text.length; i++) {
        // Если символ найден в массиве то меняем его
        if(transl[text[i]] != undefined) {
             if(curent_sim != transl[text[i]] || curent_sim != space){
                 result += transl[text[i]];
                 curent_sim = transl[text[i]];
                                                            }                                                                             
        }
        // Если нет, то оставляем так как есть
        else {
            result += text[i];
            curent_sim = text[i];
        }                              
    }          

    result = TrimStr(result);               
    //console.log(result);
    // Выводим результат 
    document.getElementById('alias').value = result;

    }


    function TrimStr(s) {
        s = s.replace(/^-/, '');
        return s.replace(/-$/, '');
    }
    // Выполняем транслитерацию при вводе текста в поле

    var title = document.getElementById('title');
        if (title){
            title.onkeyup = function(){
            translit();
            return false;
        };
    }
    
})();
//Динамически добавляем форму для создания пункта меню
(function(){
    var btnCreateItemMenu = document.getElementById('btnCreateItemMenu');
    if (btnCreateItemMenu){
        var divBaseItem = document.querySelector('.base-item');
        //console.log(divBaseItem);
        var item = divBaseItem.cloneNode(true);//создаем чистую копию пункта меню
        
        //var divBaseItem = document.getElementById('base-item');
        var options = item.getElementsByTagName('select')[1].getElementsByTagName('option');
        //console.log(item);
        var length = options.length;

        var arrOptions = [];
        for (var j=0; j < length; j++){
            arrOptions.push(options[j]);//Создаем массив с копиями option
        }
        
        setSelect();
        dinamicSelect();
        deleteItemMenu();
        
        btnCreateItemMenu.onclick = function(){
            var copyItem = item.cloneNode(true);
            copyItem.style.display = "block";
            copyItem.className="menu-item border";
            //console.log(copyItem);
            //var baseItem = document.querySelectorAll('.base-item');
            var items = document.querySelectorAll('.menu-item');
            console.log(items);
            items[0].parentNode.insertBefore(copyItem, items[items.length-1].nextSibling);
            dinamicSelect();
            deleteItemMenu()
        };
        

        
        function setSelect(){
            var divMenuItems = document.querySelectorAll('.menu-item');

            for (var k=0; k < divMenuItems.length; k++){
                var selects = divMenuItems[k].getElementsByTagName('select');
                var category = selects[0];
                var listPages = selects[1];
                var id_parent = category.selectedOptions[0].value;//id категории выбранной категории
                var options = listPages.getElementsByTagName('option');
                var length = options.length;
                for (var i = 0; i < length; i++){
                    listPages.removeChild(options[0]);
                }
                for (var i = 0; i < arrOptions.length; i++){
                    var data_parent = arrOptions[i].getAttribute('data-parent');
                    if (!data_parent){
                        listPages.appendChild(arrOptions[i].cloneNode(true));
                    }else if (data_parent.indexOf(id_parent) > -1){
                        listPages.appendChild(arrOptions[i].cloneNode(true));
                    }
                }
                
            }
        }
        //
        function deleteItemMenu(){
            var divMenuItems = document.querySelectorAll('.menu-item');

            for (var i=0; i < divMenuItems.length; i++){
                divMenuItems[i].onclick = function(event){
                    var target = event.target;
                    if (!target.classList.contains("btn-delete-item")){
                        return;
                    }
                    event.preventDefault();
                    this.parentNode.removeChild(this);
                }
            }

        }
        
        //Данная функция добавляет обработчики на select с категориями
        function dinamicSelect(){
            
            
            var divMenuItems = document.querySelectorAll('.menu-item');

            for (var i=0; i < divMenuItems.length; i++){
                var selects = divMenuItems[i].getElementsByTagName('select');
                //console.log(selects);
                var category = selects[0];
                //console.log(ids_parent);
                //console.log(category);
                
                
                category.onchange = (function(){
                    var listPages = selects[1];
                    //var listPages = this.parentNode.getElementsByTagName('select')[1];
                    //console.log(listPages);
                    
                    return function(){//console.log(listPages);
                        //var listPages = this.parentNode.getElementsByTagName('select')[1];
                        var id_parent = this.selectedOptions[0].value;//id категории выбранной категории
                        //console.log(this);
                        //console.log(id_parent);
                        //console.log(listPages);
                        var options = listPages.getElementsByTagName('option');
                        //console.log(listPages);
                        //console.log(options);
                        var length = options.length;
                        //console.log(length);
                        
                        
                        for (var i = 0; i < length; i++){
                            //console.log(options[0]);
                            //console.log(i);
                            //console.log(listPages);
                            listPages.removeChild(options[0]);
                        }
                        //console.log(arrOptions);
                        for (var i = 0; i < arrOptions.length; i++){
                            //console.log(i);
                            //listPages.removeChild(options[0]);
                            var data_parent = arrOptions[i].getAttribute('data-parent');
                            //console.log(data_parent);
                            //console.log(id_parent);
                            if (!data_parent){
                                //arrOptions[i].selected = "selected";
                                listPages.appendChild(arrOptions[i].cloneNode(true));
                            }else if (data_parent.indexOf(id_parent) > -1){
                                listPages.appendChild(arrOptions[i].cloneNode(true));
                                //console.log(listPages);
                                //console.log(options);
                            }
                            //console.log(arrOptions[i]);
                        }
                        //listPages.selectedIndex = "0";
                        //console.log(options.length);
                    };
                    
                })();
                
            }
        }
        
    }
})();

(function(){
    var btnAdd = document.getElementById("btnAdd");
    if (btnAdd){
        var divBase = document.querySelector('.base');        
        removeUpload();

        btnAdd.onclick = function(){
            var upload = divBase.cloneNode(true);//создаем чистую копию поля для загрузки
            upload.style.display = "block";
            upload.className="upload border";
            var items = document.querySelectorAll('.upload');
            divBase.parentNode.insertBefore(upload, items[items.length-1].nextSibling);
            removeUpload();
        };
        
        function removeUpload(){
            var items = document.querySelectorAll('.upload');
            for (var i=0; i<items.length; i++){
                items[i].onclick = function(event){
                    var target = event.target;
                    if (!target.classList.contains("btn-remove")){
                        return;
                    }
                    this.parentNode.removeChild(this);
                }
            }
        }
    }
    
})();