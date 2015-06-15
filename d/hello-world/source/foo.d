module foo;

class Foo
{
	
	string greet()
	{
		return "Hello world!";
	}

	unittest {
		Foo foo = new Foo();
		assert(foo.greet() == "Hello world!");	
	}
}