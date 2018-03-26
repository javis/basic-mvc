
## Requirements
* php 7.2
* php SPL extension enabled
* the example HTML templates require 'short_open_tag' enabled

## Views

- I decided to use PHP alternative syntax for my templates, it's well suited for using within HTML and doesn't requires an alternative syntax processor.
- I'm using ArrayObject as a base class for the View object. It allows me to save time
in implementing the methods for handling key-pair values.
- I implemented toString in Views so they can be used as arguments for others views.
This way we can separate layout from content templates.
- I've added the ability to access the arguments in the View that contains them. That way
a content view is aware of the context set on the layout.

## Router

- I made a very simple class for routing.It only has only one responsibility which is matching a
value with a registered route and return its callback. Getting which value is going to be provided to the Router is responsibility of the user, dispatching the callback is not responsibility of the router either.
- The router accepts any kind of callable argument as callback
- The router accepts a path as string and converts it to a regexp pattern to test routes
- It supports arguments in the registered routes with the form /user/{id} and even supports params with
custom patterns as /user/id:\\d+

## Controllers

- Since the router can receive any 'callable' as routes callbacks, there isn't really any need to come up
with anything fancy.
- To avoid creating objects unnecessarily, I've created my Controllers as static classes (so they fulfill their callable condition). If I had more time I would have probably come up with a mechanism to instantiate controllers dynamically to avoid static classes.

## Models

- Likewise, I didn't have enough time to do something fancy with them either. I would have liked to make an auto SQL generator on the base class, but I ended up writing the queries in the models by hand.
