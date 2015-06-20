
class Greeter
{

	string greet()
	{
		return "Hello World!";
	}

	unittest {
		auto greeter = new Greeter();
		assert(greeter.greet() == "Hello World!");
	}
	
}