var gulp = require("gulp");
var autoprefix = require('gulp-autoprefixer');

gulp.task('prefixer',function () {
	gulp.src('app/index.css').pipe(autoprefix({
		browsers:['last 2 versions', 'Android >= 4.0'],
		cascade:true,
		remove:true
	})).pipe(gulp.dest('app/css/'))
})

gulp.task('css',function(){
	gulp.watch('app/css/index.css',['all']);
})

gulp.task("all",function(){
	gulp.src('app/css/index.css').pipe(gulp.dest('dist/css/'));
	gulp.src('app/data/*').pipe(gulp.dest('dist/data/'));
	gulp.src('app/detail/*').pipe(gulp.dest('dist/detail/'));
	gulp.src('app/login/*').pipe(gulp.dest('dist/login/'));
	gulp.src('app/main/*').pipe(gulp.dest('dist/main/'));
	gulp.src('app/img/*').pipe(gulp.dest('dist/img/'));
	gulp.src('app/footer.html').pipe(gulp.dest('dist/'));
	gulp.src('app/index.html').pipe(gulp.dest('dist/'));
	gulp.src('app/index.js').pipe(gulp.dest('dist/'));
	gulp.src('node_modules/jquery/dist/jquery.min.js').pipe(gulp.dest('dist/lib/'));
	gulp.src('node_modules/angular/angular.min.js').pipe(gulp.dest('dist/lib/'));
	gulp.src('node_modules/angular-animate/angular-animate.min.js').pipe(gulp.dest('dist/lib/'));
	gulp.src('node_modules/angular-route/angular-route.js').pipe(gulp.dest('dist/lib/'));
	gulp.src('node_modules/weui/dist/style/weui.min.css').pipe(gulp.dest('dist/lib/'));
})