#include<stdio.h>
#define SIZE 10

int main() {
    struct student {
        char id[9];
        char name[40];
        int marking;
    } st[SIZE];
    int i,i_max,i_min,count;
    float average=0,sum=0;

    printf(" *** Structure Array 2 ***\n");
    printf("Enter data : ");
    for(i=0;i<SIZE;i++) {
        scanf("%s %s %d",st[i].id,st[i].name,&st[i].marking);
    }

    //make sure whether data is as expected.
    /*
    printf("\nOutput : \n");
    for(i=0;i<SIZE;i++) {
        printf("%s %s %d\n",st[i].id,st[i].name,st[i].marking);
    }
    */

    // find max marking
    i_max=0;
    for(i=0;i<SIZE;i++) {
        if(st[i].marking >st[i_max].marking) {
            i_max=i;
        }
    }

    // find min marking
    i_min=0;
    for(i=0;i<SIZE;i++) {
        if(st[i].marking <st[i_max].marking) {
            i_min=i;
        }
    }



    //calculate average
    for(i=0;i<SIZE;i++) {
        sum += st[i].marking;
    }
    average = sum/SIZE;
    printf("\n\n *** Analyzing Data ***\n");
    count=0;
    for(i=0;i<SIZE;i++) {
        if(st[i].marking == st[i_max].marking) {
            count++;
        }
    }
    printf("Max marking   = %d points, %d students.\n",st[i_max].marking,count);
    count=0;
    for(i=0;i<SIZE;i++) {
        if(st[i].marking == st[i_max].marking) {
            count++;
            printf("%d. %s %s %d\n",count,st[i].id,st[i].name,st[i].marking);
        }
    }




    return 0;
}