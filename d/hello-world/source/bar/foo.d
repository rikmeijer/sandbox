module bar.foo;

class Foo
{
	
	string greet(string name)
	{
		return "Hello " ~ name ~ " world!";
	}

	unittest {
		Foo foo = new Foo();
		assert(foo.greet("Rik") == "Hello Rik world!");	
	}
}