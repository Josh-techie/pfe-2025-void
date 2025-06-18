import { useState } from "react"
import Image from "next/image"
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/outline"
import { Link } from "@/ui"
import { data } from "./data"

export const config = {
	id: "custom_dynamic_fields:Events-DF",
}

const EventCard = ({ event, index, currentIndex }) => {
	// Extract month and day - this would be added to your data model
	// For now, let's pretend each event has a different date
	const dateMap = {
		0: { fromDay: "23", fromMonth: "juil", toDay: "25", toMonth: "juil" },
		1: { fromDay: "13", fromMonth: "aoû", toDay: "15", toMonth: "aoû" },
		2: { fromDay: "05", fromMonth: "sept", toDay: "07", toMonth: "sept" },
	}

	const { fromDay, fromMonth, toDay, toMonth } = dateMap[index]
	const isActive = index === currentIndex

	return (
		<div
			className={`mx-auto flex w-full max-w-4xl flex-col rounded-lg md:flex-row ${
				isActive ? "block" : "hidden"
			}`}
		>
			<div className="relative overflow-hidden md:w-2/5">
				{/* Event image with zoom effect */}
				<div className="group relative h-[280px] overflow-hidden md:h-[350px]">
					<Image
						src={event.image}
						alt={event.title}
						fill
						className="object-cover transition-transform duration-700 group-hover:scale-110"
					/>

					{/* Date overlay with gradient and rounded corners */}
					<div className="absolute right-4 top-4 w-[80px] rounded-lg bg-gradient-to-b from-[#FC3E3D] to-[#FF5F53] p-2 text-center text-white">
						<div className="text-xl font-bold">{fromDay}</div>
						<div className="text-lg font-bold">{fromMonth}</div>
						<div className="text-sm font-medium">-</div>
						<div className="text-xl font-bold">{toDay}</div>
						<div className="text-lg font-bold">{toMonth}</div>
					</div>
				</div>
			</div>

			<div className="flex flex-col p-6 md:w-3/5">
				<Link
					href={event.url || "#"}
					className="mb-3 text-lg font-bold transition hover:text-blue-600 md:text-xl"
				>
					{event.title}
				</Link>

				<div className="mb-3 flex flex-wrap gap-2">
					{event.category.map((cat, i) => (
						<span
							key={i}
							className={`rounded-full px-3 py-1 text-xs text-white md:text-sm ${
								i === 0 ? "bg-[#E85145]" : "bg-[#1E3A8A]"
							}`}
						>
							{cat}
						</span>
					))}
				</div>

				<p className="mb-4 text-sm md:text-base">{event.excerpt}</p>

				<Link
					href={event.url}
					className="w-max rounded-md bg-[#3B82F6] px-5 py-2 text-center text-sm font-medium text-white transition hover:bg-[#0069D8] md:px-6 md:py-3 md:text-base"
				>
					{event.urlContent}
				</Link>
			</div>
		</div>
	)
}

const EvenementSlider = ({ containerId = "events-slider" }) => {
	const [currentSlide, setCurrentSlide] = useState(0)

	const events = data.dataSlider
	const totalSlides = events.length

	const goToNextSlide = () => {
		setCurrentSlide((prev) => (prev + 1) % totalSlides)
	}

	const goToPrevSlide = () => {
		setCurrentSlide((prev) => (prev === 0 ? totalSlides - 1 : prev - 1))
	}

	const goToSlide = (index) => {
		setCurrentSlide(index)
	}

	return (
		<div className="bg-[#F4F8F8] py-12 md:py-16" id={containerId}>
			<div className="mx-auto max-w-7xl px-4">
				{/* Header with title in same line as blue line */}
				<div className="mb-12 flex items-center gap-4">
					<div className="h-1 w-16 bg-blue-500"></div>
					<h2 className="text-xl font-bold md:text-2xl">{data.title}</h2>
				</div>

				{/* Events Slider */}
				<div className="relative">
					{/* Event Cards */}
					<div className="overflow-hidden">
						{events.map((event, index) => (
							<EventCard
								key={index}
								event={event}
								index={index}
								currentIndex={currentSlide}
							/>
						))}
					</div>

					{/* Navigation Arrows - simplified chevron arrows */}
					<button
						onClick={goToPrevSlide}
						className="absolute -left-2 top-1/2 z-10 -translate-y-1/2 text-blue-500 transition hover:scale-110 md:-left-6"
						aria-label="Previous slide"
					>
						<ChevronLeftIcon className="h-8 w-8 stroke-[3]" />
					</button>
					<button
						onClick={goToNextSlide}
						className="absolute -right-2 top-1/2 z-10 -translate-y-1/2 text-blue-500 transition hover:scale-110 md:-right-6"
						aria-label="Next slide"
					>
						<ChevronRightIcon className="h-8 w-8 stroke-[3]" />
					</button>
				</div>

				{/* Dots Navigation - larger dots */}
				<div className="mt-6 flex justify-center gap-3">
					{events.map((_, index) => (
						<button
							key={index}
							onClick={() => goToSlide(index)}
							className={`h-4 w-4 rounded-full ${
								index === currentSlide ? "bg-blue-500" : "bg-gray-300"
							}`}
							aria-label={`Go to slide ${index + 1}`}
						/>
					))}
				</div>

				{/* View All Events Button */}
				{data.button && (
					<div className="mt-12 flex justify-center">
						<Link
							href="/tous-les-evenements"
							className="rounded bg-blue-500 px-10 py-3 text-base font-medium text-white transition hover:bg-[#0069D8] md:px-14 md:py-4 md:text-lg"
						>
							{data.button}
						</Link>
					</div>
				)}
			</div>
		</div>
	)
}

export default EvenementSlider
