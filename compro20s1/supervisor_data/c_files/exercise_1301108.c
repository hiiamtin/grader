#include<stdio.h>
int main(){
	int x,y,a,b,c,count = 0;
	printf("Enter x , y : ");
	scanf("%d%d",&x,&y);
	printf("Output\n");
	for( a = 1; a <= x ; a++ ){
		for( b = 1 ; b <= x ; b++ ){
			for( c = 1 ; c <= y ; c++){
				if( (a * b == x) && (b *c == y)){
					count++ ;
					printf("(%d,%d,%d)\n",a,b,c);
				}
			}
		}
	}
	printf("total = %d", count);
	return 0;
}