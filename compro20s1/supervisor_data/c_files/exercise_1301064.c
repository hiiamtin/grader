#include<stdio.h>
int main() {

  int a,abs_a;

  printf(" *** Show absolute value ***\n");

  printf("Enter an integer : ");

  scanf("%d",&a);
  if (a <0)
    abs_a = -1 * a;
  else
    abs_a = a;

  printf("Absolute value of %d is |%d| = %d",a,a,abs_a);



	return 0;

}