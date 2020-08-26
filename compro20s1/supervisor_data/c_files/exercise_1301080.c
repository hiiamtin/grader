// count roman characters from 1 to x
#include<stdio.h>

char roman[200];
void number2roman(int number) {
    //this function is to convert number num
    // to roman string as global variable
    int i=0,num=number;
    roman[i]='\0';
    while(num > 0)
    {
        //printf("num= %d --> %s\n",num,roman);
        if (num >= 1000)       // 1000 - m
        {
           roman[i]='m';
           num -= 1000;
           i++;
        }

        else if (num >= 900)   // 900 -  cm
        {
           roman[i]='c';
           i++;
           roman[i]='m';
           i++;
           num -= 900;
        }

        else if (num >= 500)   // 500 - d
        {
           roman[i]='d';
           num -= 500;
           i++;
        }

        else if (num >= 400)   // 400 -  cd
        {
           roman[i]='c';
           i++;
           roman[i]='d';
           i++;
           num -= 400;
        }

        else if (num >= 100)   // 100 - c
        {
           roman[i]='c';
           num -= 100;
           i++;
        }

        else if (num >= 90)    // 90 - xc
        {
           roman[i]='x';
           i++;
           roman[i]='c';
           i++;
           num -= 90;
        }

        else if (num >= 50)    // 50 - l
        {
           roman[i]='l';
           i++;
           num -= 50;
        }

        else if (num >= 40)    // 40 - xl
        {
           roman[i]='x';
           i++;
           roman[i]='l';
           i++;
           //printf("xl");
           num -= 40;
        }

        else if (num >= 10)    // 10 - x
        {
           roman[i]='x';
           i++;
           //printf("x");
           num -= 10;
        }

        else if (num >= 9)     // 9 - ix
        {
           roman[i++]='i';
           roman[i++]='x';
           //printf("ix");
           num -= 9;
        }

        else if (num >= 5)     // 5 - v
        {
           roman[i++]='v';
           //printf("v");
           num -= 5;
        }

        else if (num >= 4)     // 4 - iv
        {
           roman[i++]='i';
           roman[i++]='v';
           //printf("iv");
           num -= 4;
        }

        else if (num >= 1)     // 1 - i
        {
           roman[i++]='i';
           //printf("i");
           num -= 1;
        }

    }
    roman[i]='\0';
    //printf("%d = %s\n",number,roman);

}
int main() {
    int count_i=0, count_v=0, count_x=0, count_l=0, count_c=0, i, num_test;
    int num; // to get input from user
    char ch;
    
  	printf(" *** Count Roman Characters ***\n");
    printf("Enter last number (1..x) : ");
  	scanf("%d",&num);
    //printf("input -> %d\n",num);
    //number2roman(num);

    for(num_test=1;num_test<=num;num_test++) {
        number2roman(num_test);
        for(i=0; roman[i]!='\0';i++) {
            ch = roman[i];
            switch(ch) {
                case 'i' :
                    count_i++;
                    break;
                case 'v' :
                    count_v++;
                    break;
                case 'x' :
                    count_x++;
                    break;
                case 'l' :
                    count_l++;
                    break;
                case 'c' :
                    count_c++;
                    break;
            } // switch
        } //for

    } // for

    printf("The number of \'i\' = %d\n",count_i);
  	printf("The number of \'v\' = %d\n",count_v);
  	printf("The number of \'x\' = %d\n",count_x);
  	printf("The number of \'l\' = %d\n",count_l);
  	printf("The number of \'c\' = %d\n",count_c);
  	//printf("%d %d %d %d %d\n",count_i,count_v,count_x,count_l,count_c);

    return 0;
}