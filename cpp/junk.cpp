#include <iostream>
#include <string>
#include <fstream>
using namespace std;

int main()
{
	string a, b;
	ifstream f;

	f.open("Lesson21.flash");
	f >> a;
	while (f >> a >> b)
		cout << a <<"\n" << b <<"\n\n";
	f.close();



	return 0;
}
