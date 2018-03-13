package snippet;
import java.util.Scanner;

public class DemoStrings
{
	public static void main(String[] args)
	{
		// test1();
		// test2();
		// test3();
		// test4();
		test5();
	}

	private static void test1()
	{
		Scanner scanner = new Scanner(System.in);

		System.out.print("Wil je nog een keertje spelen? ");
		String antwoord = scanner.nextLine();

		//if (antwoord == "ja") 	// Werkt niet
		if (antwoord.equals("ja"))	// Altijd equals() gebruiken!
		{
			System.out.println("Leuk, daar gaan we...");
		}
		else
		{
			System.out.println("Nou doei dan");
		}

		scanner.close();
	}

	private static void test2()
	{
		String a1 = new String("bla");
		String a2 = new String("bla");

		System.out.println("a1 == a2 levert " + (a1 == a2));
		System.out.println("a1.equals(a2) levert " + (a1.equals(a2)));
		
		// Twee verschillende objecten met dezelfde inhoud
	}

	private static void test3()
	{
		String a1 = new String("a");
		String a2 = a1;

		System.out.println("a1 == a2 levert " + (a1 == a2));
		System.out.println("a1.equals(a2) levert " + (a1.equals(a2)));
		
		// Twee references naar hetzelfde object
	}

	private static void test4()
	{
		String a1 = new String("a");
		String a2 = a1;

		a1 = "a";	// Nieuw object met inhoud "b"

		System.out.println("a1 == a2 levert " + (a1 == a2));
		System.out.println("a1.equals(a2) levert " + (a1.equals(a2)));
	}

	private static void test5()
	{
		// Impliciete constructie van een String

		String a1 = "a";
		String a2 = "a";

		System.out.println("a1 == a2 levert " + (a1 == a2));
		System.out.println("a1.equals(a2) levert " + (a1.equals(a2)));
		
		// Onverwacht wijzen a1 en a2 nu naar hetzelfde object
		// Dit is een optimalisatie van Java die alleen werkt
		// bij Strings die je maakt zonder expliciet new String(...)
		// te zeggen
	}
}
