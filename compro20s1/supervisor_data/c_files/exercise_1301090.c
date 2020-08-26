#include<stdio.h>
#define SIZE 5000
char c[SIZE][SIZE];
int main()
{
    int a=0,n,i,j,b=SIZE/2,k=SIZE/2,cha=0;
    
    printf("Enter positive number : ");
    scanf("%d",&n);
    if(n<=0) {
      printf("Out of range --> %d\n",n);
      return 0;
    }
    for(i=0;n;i++)
    {
        for(j=0;j<=i&&n;j++)
        {
            if(i%2)
            {
                c[a][2500-j]='A'+cha%26;
                n--;
                cha++;
                if(b>2500-j)
                    b=2500-j;
            }
            else
            {
                c[a][2500+j]='A'+cha%26;
                n--;
                cha++;
                if(k<2500+j)
                    k=2500+j;
            }
        }
        a++;
    }
    for(i=0;i<a;i++){
        for(j=b;j<=k;j++)
        {
            if(c[i][j]>='A')
                printf("%c",c[i][j]);
            else
                printf(".");
        }
        printf("\n");
    }
    return 0;
}