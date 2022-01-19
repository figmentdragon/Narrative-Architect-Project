Objects are context independent

When I say objects are context independent, I mean they don’t know where they’re used. You could pick any object up, throw it somewhere else and it won’t break the structure of your site.

This also means objects should not change any structure outside itself. So, object blocks cannot contain any of these properties/values:

    absolute or fixed position.
    margin.
    padding (unless you have a background-color applied. In this case, it doesn’t interrupt break the alignment outside the object).
    float.
    etc…

Since you know objects need to be context independent, you immediately know the .button in our site-wide navigation example earlier cannot contain any margins.
