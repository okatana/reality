# REALITY тестовое задание 

## работающая версия

[okatana.16mb.com/reality/](okatana.16mb.com/reality/)

## ТЗ 

Нужно сделать сайт о недвижимости.
### Требования
Настройка сайта
Сделайте сайт, установите WordPress. Можно использовать бесплатный хостинг или свой (если имеется)
Установить тему https://understrap.com/
Создание дочерней темы - для настройки/доработки
### База недвижимости
Создание тип поста “Недвижимость” (можно использовать плагин https://ru.wordpress.org/plugins/custom-post-type-ui/ или писать код)
Для нового типа поста необходимо создать таксономию “Тип недвижимости”. Добавить несколько типов: частный дом, квартира, офис и т.д.
Должна быть фотография или фотографии объекта недвижимости
### Метаполя
Для нового типа поста добавить несколько произвольных полей, использовать плагин ACF
Площадь
Стоимость
Адрес
Жилая площадь
Этаж
### Вывести поля на странице с объектом
Добавить 11-20 записей объектов недвижимости
База Городов - для хранения данных о Городах (можно по аналогии с тем как делается база недвижимости)
Реализовать связь между постами Недвижимость и Города - таким образом, чтобы к одному Городу было привязано несколько объектов недвижимости
Город - можно ввести название, описание и выбрать картинку с фотографией города
### На главной странице сайта
Вывести последние объекты недвижимости и города на главной странице в отдельных секциях
пользователь может открыть страницу с объектом недвижимости и увидеть его данные
пользователь может открыть страницу с городом и увидеть до 10 последних объектов недвижимости в этом городе
В списке недвижимости на главной странице должны отображаться не только наименования объектов недвижимости, но и их характеристики
Внизу форма добавления объекта недвижимости - должна работать с учетом AJAX и с заполнением основных полей