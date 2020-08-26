#include<stdio.h>
int main() {
    int a1,a2,n,i,t;
    printf("******** Fibonacci series ********\n");
    printf("*  A(1) and A(2) are assigned.   *\n");
    printf("*     A(n) = A(n-1) + A(n-2)     *\n");
    printf("*--------------------------------*\n");
    printf("\nEnter A1 A2 n : ");
    scanf("%d %d %d",&a1, &a2, &n);

    printf("\n%d %d ",a1,a2);
    for(i=3; i<=n; i++){

        printf("%d ",a1+a2);
        t=a1+a2;
        a1=a2;
        a2=t;
    }
    return 0;

}