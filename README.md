# JSON Templator

Вывод данных в шаблон из json-схемы.

```scheme``` - имя схемы, на пример, pets.

```keys``` - отображаемые поля.

```values``` - поиск по значениям.

```sort``` - сортировка по полям, на пример, ```name:desc```

```mode``` - режим смешения.

    sum - все строки, в которых есть любые значения из списка.

    intersect - строки, соответствующие всему набору значений.

```view``` - шаблон отображения, на пример, table.

Пример: ```?scheme=pets&keys=name,pet_type&values=,собака&sort=pet_type:asc,name:desc&mode=sum&view=table```