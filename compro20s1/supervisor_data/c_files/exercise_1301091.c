#include<stdio.h>
int main() {
    int count[10],num1=0,num2=0,i,j,k,max,min,temp;
    printf(" *** Digit counting ***\n");
    printf("Enter two counting numbers : ");
    scanf("%d %d",&num1,&num2);
    if (num1<=0 || num2 <=0) {
      printf("Invalid input !!!\n");
      return 0;
    }
    for(i=0;i<10;i++) {
        count[i] = 0;
    }
    if(num1>num2) {
        min = num2;
        max = num1;
    } else {
        min = num1;
        max = num2;
    }
    for(i=min;i<=max;i++) {
        temp = i;
        while (temp>0) {
            count[temp%10]++;
            temp /= 10;
        }
    }

    for(i=0;i<10;i++) {
        printf ("%d --> %d\n",i, count[i]);
    }

}
