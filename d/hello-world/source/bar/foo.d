module bar.foo;

class Foo
{
	
	string greet(string name)
	{
		return "Hello " ~ name ~ " world!";
	}
	string greet(int age)
	{
		if (age < 19) {
			return this.greet("young");
		} else {
			return this.greet("old");
		}
	}

	unittest {
		Foo foo = new Foo();
		assert(foo.greet("Rik") == "Hello Rik world!");	
		assert(foo.greet(18) == "Hello young world!");	
		assert(foo.greet(19) == "Hello old world!");	
	}
}