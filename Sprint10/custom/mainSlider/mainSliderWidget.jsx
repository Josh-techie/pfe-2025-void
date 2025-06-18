import { useState, useEffect, useCallback, useRef } from "react"
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/outline"
import { Link } from "@/ui"
import Image from "next/image"

export const config = {
	id: "custom_dynamic_fields:Slider-Main",
}

export const MainSliderWidget = ({ data }) => {
	const [currentSlide, setCurrentSlide] = useState(0)
	const [slides, setSlides] = useState([])
	const [touchStart, setTouchStart] = useState(0)
	const [touchEnd, setTouchEnd] = useState(0)
	const [isDragging, setIsDragging] = useState(false)
	const [startX, setStartX] = useState(0)
	const [scrollLeft, setScrollLeft] = useState(0)
	const sliderRef = useRef(null)
	const slideInterval = useRef(null)

	// Initialize slides from data
	useEffect(() => {
		if (data?.components) {
			setSlides(data.components)
		}
	}, [data])

	// Auto-slide functionality with reset on manual interaction
	const startAutoSlide = useCallback(() => {
		clearInterval(slideInterval.current)
		slideInterval.current = setInterval(() => {
			setCurrentSlide((prev) => (prev === slides.length - 1 ? 0 : prev + 1))
		}, 7000)
	}, [slides.length])

	useEffect(() => {
		startAutoSlide()
		return () => clearInterval(slideInterval.current)
	}, [startAutoSlide, currentSlide])

	const nextSlide = useCallback(() => {
		setCurrentSlide((prevSlide) => (prevSlide === slides.length - 1 ? 0 : prevSlide + 1))
		startAutoSlide() // Reset timer when manually changing slides
	}, [slides.length, startAutoSlide])

	const prevSlide = useCallback(() => {
		setCurrentSlide((prevSlide) => (prevSlide === 0 ? slides.length - 1 : prevSlide - 1))
		startAutoSlide() // Reset timer when manually changing slides
	}, [slides.length, startAutoSlide])

	const goToSlide = useCallback(
		(slideIndex) => {
			setCurrentSlide(slideIndex)
			startAutoSlide() // Reset timer when manually changing slides
		},
		[startAutoSlide]
	)

	// Navigate to slide link handler
	const handleSlideClick = useCallback((slideLink) => {
		if (slideLink?.url) {
			window.location.href = slideLink.url
		}
	}, [])

	// Touch event handlers for mobile swipe
	const handleTouchStart = (e) => {
		setTouchStart(e.targetTouches[0].clientX)
	}

	const handleTouchMove = (e) => {
		setTouchEnd(e.targetTouches[0].clientX)
	}

	const handleTouchEnd = () => {
		if (touchStart - touchEnd > 50) {
			// Swipe left
			nextSlide()
		}

		if (touchStart - touchEnd < -50) {
			// Swipe right
			prevSlide()
		}
	}

	// Mouse drag handlers for desktop
	const handleMouseDown = (e) => {
		setIsDragging(true)
		setStartX(e.pageX - (sliderRef.current?.offsetLeft || 0))
		setScrollLeft(currentSlide * (sliderRef.current?.offsetWidth || 0))
	}

	const handleMouseLeave = () => {
		setIsDragging(false)
	}

	const handleMouseUp = (e) => {
		if (!isDragging) return

		setIsDragging(false)

		// If movement was small, treat as click
		if (Math.abs(e.pageX - startX - (sliderRef.current?.offsetLeft || 0)) < 10) {
			const slide = slides[currentSlide]
			if (slide?.link?.url) {
				handleSlideClick(slide.link)
			}§
		}
	}

	const handleMouseMove = (e) => {
		if (!isDragging) return
		e.preventDefault()

		const x = e.pageX - (sliderRef.current?.offsetLeft || 0)
		const walk = (x - startX) * 1.5
		const dragDistance = scrollLeft - walk

		// Calculate which slide to snap to
		const slideWidth = sliderRef.current?.offsetWidth || 0
		const newSlideIndex = Math.round(dragDistance / slideWidth)

		if (
			newSlideIndex >= 0 &&
			newSlideIndex < slides.length &&
			newSlideIndex !== currentSlide
		) {
			setCurrentSlide(newSlideIndex)
			startAutoSlide() // Reset timer when dragging to a new slide
		}
	}

	if (!slides.length) return null

	return (
		<div
			className="relative h-[500px] w-full overflow-hidden md:h-[600px]"
			ref={sliderRef}
			role="region"
			aria-label="Image Slider"
		>
			{/* Draggable area */}
			<div
				className="absolute inset-0 z-10 h-full w-full"
				style={{ cursor: isDragging ? "grabbing" : "grab" }}
				onTouchStart={handleTouchStart}
				onTouchMove={handleTouchMove}
				onTouchEnd={handleTouchEnd}
				onMouseDown={handleMouseDown}
				onMouseLeave={handleMouseLeave}
				onMouseUp={handleMouseUp}
				onMouseMove={handleMouseMove}
				role="presentation"
			></div>

			{/* Slick track */}
			<div
				className="slick-track flex h-full w-full transition-transform duration-700 ease-in-out"
				style={{
					width: `${slides.length * 100}%`,
					transform: `translate3d(-${currentSlide * (100 / slides.length)}%, 0px, 0px)`,
					transitionTimingFunction: "cubic-bezier(0.585, -0.005, 0.635, 0.92)",
				}}
			>
				{slides.map((slide, index) => {
					// Special case for COVID-19 slide
					const isCovid = slide.title.includes("COVID-19")

					return (
						<div
							key={index}
							className={`slick-slide relative h-full min-w-full ${
								currentSlide === index ? "slick-current slick-active" : ""
							}`}
							data-slick-index={index}
							aria-hidden={currentSlide !== index}
							style={{
								width: `${100 / slides.length}%`,
							}}
						>
							{/* Background color for COVID slide */}
							{isCovid && <div className="absolute inset-0 z-0 bg-[#64C7C4]"></div>}

							{/* Image using Next.js Image component - adjusted for better fit */}
							<div
								className={`relative h-full w-full ${
									isCovid ? "ml-auto w-1/2" : "w-full"
								}`}
							>
								<Image
									src={slide.image[0]._default}
									alt={slide.image[0].meta?.alt || "Slide image"}
									fill
									sizes="100vw"
									priority={index === currentSlide}
									className={`${
										isCovid ? "object-contain object-right" : "object-cover object-center"
									}`}
									quality={90}
									style={{
										objectPosition: isCovid ? "right center" : "center center",
									}}
								/>
							</div>

							{/* Semi-transparent overlay - not for COVID slides */}
							{!isCovid && <div className="absolute inset-0 bg-black opacity-30"></div>}

							{/* Content container */}
							<div className="container relative z-10 mx-auto h-full px-4">
								<div className="flex h-full items-center">
									{/* Card with blue vertical line */}
									<div className="relative max-w-[85%] rounded-lg bg-white p-6 shadow-md md:max-w-[45%] md:p-8">
										{/* Blue vertical line */}
										<div className="absolute left-0 top-0 h-full w-1 bg-blue-500"></div>

										{/* Card content with proper spacing */}
										<div className="pl-3">
											<h3 className="mb-3 text-xl font-bold leading-tight text-[#1a3b6d] md:text-2xl lg:text-3xl">
												{slide.title}
											</h3>
											<p className="mb-6 text-sm leading-relaxed text-[#1a3b6d] md:text-base">
												{slide.description}
											</p>
											{slide.link && (
												<Link
													href={slide.link.url}
													className="text-sm font-medium text-[#0076ff] hover:underline md:text-base"
													id={slide.link?.attributes?.id || ""}
													rel={slide.link?.attributes?.rel || ""}
													target={slide.link?.attributes?.target || "_self"}
												>
													{slide.link.title}
												</Link>
											)}
										</div>
									</div>
								</div>
							</div>
						</div>
					)
				})}
			</div>

			{/* Dots - visible on mobile */}
			<ul className="slick-dots absolute bottom-5 left-1/2 z-20 flex -translate-x-1/2 transform space-x-3 md:hidden">
				{slides.map((_, index) => (
					<li key={index} className={currentSlide === index ? "slick-active" : ""}>
						<button
							type="button"
							className={`h-3 w-3 rounded-full ${
								currentSlide === index ? "bg-[#0076ff]" : "bg-white"
							}`}
							onClick={() => goToSlide(index)}
							aria-label={`Go to slide ${index + 1}`}
						>
							<span className="sr-only">{index + 1}</span>
						</button>
					</li>
				))}
			</ul>

			{/* Progress bar slider - visible on desktop */}
			<div className="absolute bottom-5 left-0 right-0 z-20 hidden px-8 md:block">
				<div className="h-1 w-full overflow-hidden rounded-full bg-gray-300/50">
					<div
						className="h-full bg-blue-500 transition-all duration-700 ease-in-out"
						style={{ width: `${((currentSlide + 1) / slides.length) * 100}%` }}
					></div>
				</div>
			</div>

			{/* Navigation arrows */}
			<div className="absolute left-0 right-0 top-1/2 z-20 flex -translate-y-1/2 transform justify-between px-4">
				<button
					className="text-blue-500 hover:text-blue-700"
					onClick={(e) => {
						e.stopPropagation()
						prevSlide()
					}}
					aria-label="Previous slide"
				>
					<ChevronLeftIcon className="h-8 w-8" />
				</button>
				<button
					className="text-blue-500 hover:text-blue-700"
					onClick={(e) => {
						e.stopPropagation()
						nextSlide()
					}}
					aria-label="Next slide"
				>
					<ChevronRightIcon className="h-8 w-8" />
				</button>
			</div>
		</div>
	)
}

export default MainSliderWidget
