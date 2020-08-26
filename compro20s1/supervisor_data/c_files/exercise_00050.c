#include<stdio.h>
int main() {
  float c,f;
  printf(" *** Convert Celcius to Fahrenheit ***\n");
  printf("Enter temperature in degree celcius : ");
  scanf("%f",&c);
  f = (c)*9/5+32;
  printf("%.2f degrees equals %.2f degree Fahrenheit.\n",c,f);
	return 0;
}