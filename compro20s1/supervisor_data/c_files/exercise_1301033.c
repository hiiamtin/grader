#include <stdio.h>

int main(int argc, char **argv) {
#ifdef __clang_major__
    printf ("clang detected version %d.%d\n", __clang_major__, __clang_minor__);
#endif

#ifdef __GNUC__
    // note that clang 3.7 declares itself as a gcc 4.2"
    printf ("gcc detected version %d.%d\n", __GNUC__, __GNUC_MINOR__);
#endif
}