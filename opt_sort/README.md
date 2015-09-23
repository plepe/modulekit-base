opt_sort(data, sorts)
====================
Order data by custom sort options. It will return the new data array.

Example:
* data:

```json
[
    {
        'name': 'Foo',
        'age': 10
    },
    {
        'name': 'Bar',
        'age': 20
    },
    {
        'name: 'Foo',
        'age': 5
    }
]

* sorts:
List of sort options. Each option is a hash array:
  * key: which key to order by
  * type: "alpha" (default), "num"/"numeric", "case" (alphabetic, but case insenstive), "nat" (natural sort algorithm)
  * dir: "asc" (default) or "desc"
  * weight: defines order of sorting, if there are several sort options (the lower the value the more important; default 0).
