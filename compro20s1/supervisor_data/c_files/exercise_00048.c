#include<stdio.h>
#include<limits.h>
int main() {
  unsigned long n;
  
  printf(" *** Display integer in different styles ***\n");
  printf("Enter an integer : ");
  scanf("%ld",&n);
  printf("Your number : %ld\n",n);
  printf("variable size = %d bytes\n",sizeof(n));
  printf("last 3 digits : %3ld\n",n%1000);
  printf("next 3 digits : %3ld\n",n/1000%1000);
  printf("next 3 digits : %3ld\n",n/1000000%1000);
  printf("next 3 digits : %3ld\n",n/1000000000);
  printf("comma format  : %ld,%ld,%ld,%ld\n",n/1000000000,n/1000000%1000,n/1000%1000,n%1000);

  return 0;
}
/*
#include <stdio.h>
#include <limits.h>

int main() {

   printf("The number of bits in a byte %d\n", CHAR_BIT);

   printf("The minimum value of SIGNED CHAR = %d\n", SCHAR_MIN);
   printf("The maximum value of SIGNED CHAR = %d\n", SCHAR_MAX);
   printf("The maximum value of UNSIGNED CHAR = %d\n", UCHAR_MAX);

   printf("The minimum value of SHORT INT = %d\n", SHRT_MIN);
   printf("The maximum value of SHORT INT = %d\n", SHRT_MAX); 

   printf("The minimum value of INT = %d\n", INT_MIN);
   printf("The maximum value of INT = %d\n", INT_MAX);

   printf("The minimum value of CHAR = %d\n", CHAR_MIN);
   printf("The maximum value of CHAR = %d\n", CHAR_MAX);

   printf("The minimum value of LONG = %ld\n", LONG_MIN);
   printf("The maximum value of LONG = %ld\n", LONG_MAX);
  
   return(0);
}
*/