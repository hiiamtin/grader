#include<stdio.h>
int main() {
    int sum=0,num1=0,num2=0,i,j,k,max,min,temp;
    printf(" *** Summation of common factor ***\n");
    printf("Enter two positive numbers : ");
    scanf("%d %d",&num1,&num2);

    if(num1>num2) {
        min = num2;
        max = num1;
    } else {
        min = num1;
        max = num2;
    }
    for(i=1;i<=min;i++) {
        if(num1%i==0 && num2%i==0)
            sum += i;
    }

    printf("Summation of common factors (%d and %d) ==> %d\n",num1,num2,sum);

}
