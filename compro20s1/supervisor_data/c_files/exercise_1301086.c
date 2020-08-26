#include<stdio.h>
int main() {
    int num,r,c,d=1;
    printf("Input : ");
    scanf("%d",&num);
    if(num<=0) {
        printf("No Answer\n");
        return 0;
    }
    for(r=1;r<=num;r++) {
        for(c=1;c<=num;c++) {
            printf("%3d",d);
            d++;
            if(d==10) 
                d=1;
        }
        printf("\n");
    }
	return 0;
}