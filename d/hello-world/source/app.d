import std.stdio;
import bar.foo;

void main()
{
	Foo foo = new Foo;
	writeln(foo.greet("Rik"));
	writeln(foo.greet(9));
}
