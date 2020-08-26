#include<stdio.h>
int main() {
  int a,b,c,d,max,min;
  printf(" *** Find Max+Min and Max/Min ***\n");
  printf("Enter 4 integers : ");
  scanf("%d %d %d %d",&a,&b,&c,&d);
  
  // find max
  if (a>=b && a>=b && a>=c && a>=d)
    max = a;
  else if (b>=c && b>=d)
    max = b;
  else if (c>=d)
    max = c;
  else
    max = d;
  
  // find min
  if (a<=b && a<=b && a<=c && a<=d)
    min = a;
  else if (b<=c && b<=d)
    min = b;
  else if (c<=d)
    min = c;
  else
    min = d;
  
  printf("Max + Min = %d + %d = %d\n",max,min,max+min);
  printf("Max / Min = %d / %d = %d\n",max,min,max/min);
  printf("Max / Min = %d / %d = %.3f\n",max,min,1.0*max/min);
  
	return 0;
}